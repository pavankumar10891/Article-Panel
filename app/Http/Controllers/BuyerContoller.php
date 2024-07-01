<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;


class BuyerContoller extends Controller
{
    public function index(Request $request)
    {
        if(Auth()->user()->hasRole('admin')){
            $results = User::get()->filter(function ($user) {
                return $user->hasRole('Buyer');
            })->paginate(10); 
            
            return view('buyers.buyers', compact('results'));
        }else{
            return redirect()->back()->with('error', 'you are not authorized');
        }    
    }
    public function view($id){
        $model = User::where('id',$id)->first();
        return view('buyers.buyers_view', compact('model')); 
    }

    public function edit($id)
    {
        if(Auth()->user()->hasRole('admin')){
            $user = User::find($id);            
            return view('buyers.edit', compact('user'));
        }else{
            return redirect()->back();
        }
    }

    public function update($id, Request $request){
        if(Auth()->user()->hasRole('admin')){

            $request->validate([
                'name' => 'required',
                'email' => 'required|email|unique:users,email,'.$id,
                'password' => 'confirmed',
                'mobile' => 'required',
                'designation' => 'required',
                'bio' => 'required',
            ]);
            $user = User::find($id);  
            if(!empty($request->password)){
                $user->password = $request->password;
            }  
            $user->name = $request->name;
            $user->email = $request->email;
            $user->mobile = $request->mobile;
            $user->designation = $request->designation;
            $user->bio = $request->bio;
            $user->save();
            return redirect()->back()->with('success', 'successfully updated');
        } else{
            return redirect()->back();
        }
    }
    
}
