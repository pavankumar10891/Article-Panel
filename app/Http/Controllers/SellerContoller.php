<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\TaskMangement;


class SellerContoller extends Controller
{
    public function index(Request $request)
    {
        if(Auth()->user()->hasRole(['admin', 'Buyer'])){
            $results = User::withCount('writerTask')->get()->filter(function ($user) {
                return $user->hasRole('Writer');
            })->paginate(10);  
        }else{
            return redirect()->back()->with('you are not authrized'); 
        }
          
        return view('writers.index', compact('results'));
    }

    public function show($id){
        $model = User::find($id);
        $results = [];
           if(Auth()->user()->hasRole('admin')){
            $results = TaskMangement::with('user')->orderBy('id','desc')->paginate(10);
           }elseif(Auth()->user()->hasRole('Buyer')){
            $results = TaskMangement::where('assign_user_id', 0)->where('created_user_id', auth()->user()->id)->with('user')->orderBy('id','desc')->paginate(10);
        }else{
            return redirect()->back();
           }
        return view('writers.show', compact('model','results'));
    }

    public function edit($id)
    {
        if(Auth()->user()->hasRole('admin')){
            $user = User::find($id);            
            return view('writers.edit', compact('user'));
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
                'address' => 'required',
                'ppw' => 'required',
                'bio' => 'required',
                'expert_niche' => 'required',
                'experience' => 'required',
                'daily_capecity' => 'required'
            ]);
            $user = User::find($id);  
            if(!empty($request->password)){
                $user->password = $request->password;
            }
            $user->name = $request->name;
            $user->email = $request->email;
            $user->mobile = $request->mobile;
            $user->address = $request->address;
            $user->ppw = $request->ppw;
            $user->bio = $request->bio;
            $user->expert_niche = $request->expert_niche;
            $user->experience = $request->experience;
            $user->daily_capecity = $request->daily_capecity;
            $user->save();
            return redirect()->back()->with('success', 'successfully updated');
        } else{
            return redirect()->back();
        }
    }


}
