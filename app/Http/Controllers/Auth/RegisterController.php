<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;


class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    //use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    

   public function writerSignup(Request $request)
   {     
        $this->validate($request, [
            'first_name'        => ['required', 'string', 'max:255'],
            'last_name'         => ['required', 'string', 'max:255'],
            'email'             => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'mobile'            => ['required', 'string', 'max:255', 'unique:users'],
            'designation'       => ['required'],
            'ppw'               => ['required'],
            'experience'        => ['required'],
            'daily_capecity'    => ['required'],
            'expert_niche'      => ['required'],
            'password'            => 'required|min:8|confirmed',

        ]);
        $userCount  = User::count();
        $input      = $request->all();
        $input['name']        =  $request->first_name.' '.$request->last_name; 
        $input['password']    = Hash::make($input['password']);
        $user = User::create($input);
        $user->assignRole(['Writer']);

        return redirect()->back()->with('success', 'Register successfully');
   }

   public function buyerSignup(Request $request)
   {     
        $this->validate($request, [
            'first_name'        => ['required', 'string', 'max:255'],
            'last_name'         => ['required', 'string', 'max:255'],
            'email'             => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'mobile'            => ['required', 'string', 'max:255', 'unique:users'],
            'designation'       => ['required'],
            'password'            => 'required|min:8|confirmed',
        ]);
        $userCount  = User::count();
        $input      = $request->all();
        $input['name']        =  $request->first_name.' '.$request->last_name; 
        $input['password']    = Hash::make($input['password']);
        $user = User::create($input);
        $user->assignRole(['Buyer']);
        return redirect()->back()->with('success', 'Register successfully');

   }
}
