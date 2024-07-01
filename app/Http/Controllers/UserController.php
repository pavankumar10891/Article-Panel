<?php

namespace App\Http\Controllers;

use Hash;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * create a new instance of the class
     *
     * @return void
     */
    function __construct()
    {
        $this->middleware('permission:user-list|user-create|user-edit|user-delete', ['only' => ['index','store']]);
        $this->middleware('permission:user-create', ['only' => ['create','store']]);
        $this->middleware('permission:user-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:user-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = User::orderBy('id', 'desc')->paginate(10);

        return view('users.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::pluck('name','name')->all();

        return view('users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed',
            'roles' => 'required'
        ]);

        $input = $request->all();
        $input['password'] = Hash::make($input['password']);

        if($request->hasFile('image')){
            $path = public_path('uploads/profile_pic/');;
            if ( ! file_exists($path) ) {
                mkdir($path, 0777, true);
            }
            $fileName = time().'.'.$request->image->extension();  
            $request->image->move(public_path('uploads/profile_pic'), $fileName);
            $input['image'] = $fileName;
        }
        $user = User::create($input);
        $user->assignRole($request->input('roles'));

        return redirect()->route('users.index')
            ->with('success', 'User created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);

        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        $roles = Role::pluck('name', 'name')->all();
        $userRole = $user->roles->pluck('name', 'name')->all();

        return view('users.edit', compact('user', 'roles', 'userRole'));
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
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$id,
            'password' => 'confirmed',
            'roles' => 'required',

        ]);

        $input = $request->all();

        if(!empty($input['password'])) {
            $input['password'] = Hash::make($input['password']);
        } 
        if($request->hasFile('image')){
            $path = public_path('uploads/profile_pic/');;
            if ( ! file_exists($path) ) {
                mkdir($path, 0777, true);
            }
            $fileName = time().'.'.$request->image->extension();  
            $request->image->move(public_path('uploads/profile_pic'), $fileName);
            $input['image'] = $fileName;
        }

        $user = User::find($id);
        $user->update($input);

        DB::table('model_has_roles')
            ->where('model_id', $id)
            ->delete();

        $user->assignRole($request->input('roles'));

        return redirect()->route('users.index')
            ->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::find($id)->delete();
        return response()->json(['success'=>true, 'url' => route('users.index')]);
        //return response()->json(['url' => route('users.index')]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request) {
        auth()->logout();
        return redirect()->route('login');
    }

    public function profile() {
        $user = auth()->user();
        return view('users.profile', compact('user'));
    }

    public function profileUpdate(Request $request) {
        $user = auth()->user();
        $required = auth()->user()->hasRole('customer') ? 'required' :'';
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.auth()->user()->id,
            'password' => 'confirmed',
            'phone' => $required,
        ]);

        $input = $request->all();
        $user = User::find($user->id);
        $userImage = auth()->user()->image;
        if($request->hasFile('image')){
            $path = public_path('uploads/profile_pic/');;
            if ( ! file_exists($path) ) {
                mkdir($path, 0777, true);
            }
            $fileName = time().'.'.$request->image->extension();  
            $request->image->move(public_path('uploads/profile_pic'), $fileName);
            $input['image'] = $fileName;
            $user->image = $input['image']; 
         }

        if(isset($input['password'])) {
            $$user->password = Hash::make($input['password']);
        } 
        $user->name = $input['name'];
        $user->mobile = $input['mobile'];
        $user->address = $input['address'] ?? '';
        $user->designation = $input['designation'] ?? '';
        $user->bio = $input['bio'] ?? '';
        $user->expert_niche = $input['expert_niche'] ?? '';
        $user->daily_capecity = $input['daily_capecity'] ?? '';
        $user->experience = $input['experience'] ?? '';
        $user->save();

        return redirect()->route('profile')->with('success', 'Profile updated successfully.');;
    }
}
