<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\User;
use App\Models\License;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;

class CutomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $customers = User::orderBy('created_at','desc')->orderBy('name','asc')->get()->filter(function ($user) {
            return $user->hasRole('customer');
        })->paginate(10);
       return view('customers.index', compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create()
    {
        $customers = User::get()->filter(function ($user) {
            return $user->hasRole('customer');
        })->pluck('name', 'id');
        return view('customers.create', compact('customers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
                'name'              => 'required',
                'email'             => 'required|email|unique:users,email',
                //'operator_email'    => 'required',
                'user_name'         => 'required|unique:users,user_name',
                'phone'             => 'required',
                //'website'           => 'required|url',
                //'company_number'    => 'required',
                'password'          => 'required|min:6',
                'confirm_password'  => 'required|same:password',
                'image'             => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ],
            [
                'name.required'             => 'Name field is required',
                'email.required'            => 'Email field is required',
                'email.email'               => 'Email is not valid',
                //'operator_email.required'   => 'Operator email field is required',
                //'operator_email.email'      => 'Operator email is not valid',
                'email.unique'              => 'Email already exists',
                'user_name.required'        => 'User name field is required',
                'user_name.unique'          => 'User name already exists',
                'phone.required'            => 'Phone field is required',
                //'company_number.required'   => 'Company number field is required',
                'password.required'         => 'Password field is required',
                'confirm_password.required' => 'Confirm password field is required',
            ]
        );
        $input = $request->all();
        if($request->hasFile('image')){
            $path = public_path('public/profile/');
            if ( ! file_exists($path) ) {
                mkdir($path, 0777, true);
            }
            $fileName = time().'.'.$request->image->extension();
            $request->image->move(public_path('uploads/profile_pic'), $fileName);
            $input['image'] = $fileName;
         }
        $user = User::create($input);
        $user->assignRole(array('customer'));
        return redirect()->route('customer.index')
            ->with('success', 'Customer created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
       $user = User::where('id', $id)->first();
       if(!empty($user)){
           $orders =  Order::with('customer')->with('plan')->where('is_deleted',0);
           $orders->where('user_id', $id);
           $orders =  $orders->orderBy('created_at','desc')->paginate(10);
           return view('customers.show', compact('user', 'orders'));
       }else{
            return redirect()->back()
            ->with('error', 'Record not found');
       }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
       $user = User::where('id', $id)->first();
       if(!empty($user)){
            return view('customers.edit', compact('user'));
       }else{
            return redirect()->back()
            ->with('error', 'Record not found');
       }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
                'name'              => 'required',
                'email'             => 'required|email|unique:users,email,'.$id,
                //'operator_email'    => 'required',
                'user_name'         => 'required|unique:users,user_name,'.$id,
                'phone'             => 'required',
                'website'           => 'required|url',
                //'company_number'    => 'required',
                //'password'          => '',
                'confirm_password'  => 'same:password',
                'image'             => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ],
            [
                'name.required'             => 'Name field is required',
                'email.required'            => 'Email field is required',
                'email.email'               => 'Email is not valid',
                'email.unique'              => 'Email already exists',
                'operator_email.required'   => 'Operator email field is required',
                'operator_email.email'      => 'Operator email is not valid',
                'user_name.required'        => 'User name field is required',
                'user_name.unique'          => 'User name already exists',
                'phone.required'            => 'Phone field is required',
                'company_number.required'   => 'Company number field is required',
                'password.required'         => 'Password field is required',
                'confirm_password.required' => 'Confirm password field is required',
            ]
        );
        $input = $request->all();
        $user = User::find($id);
        if(!empty($input['password'])) {
            $input['password'] = Hash::make($input['password']);
        } else {
            $input = Arr::except($input, array('password'));
        }

        if($request->hasFile('image')){
            $path = public_path('uploads/profile_pic/');
            if ( ! file_exists($path) ) {
                mkdir($path, 0777, true);
            }
            $fileName = time().'.'.$request->image->extension();
            $request->image->move(public_path('uploads/profile_pic'), $fileName);
            $input['image'] = $fileName;
         }
         $user->update($input);
        return redirect()->route('customer.index')
            ->with('success', 'Customer update successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $order = User::find($id);
        if(!empty($order)){
            User::where('id',$id)->delete();
            return response()->json([
                'success' => true,
                'url' => route('customer.index'),
                'message' =>'User delete successfully.',
            ]);
        }else{
            return response()->json([
                'success' => false,
                'message' =>'Something went to wrong',
            ]);
        }
    }

}
