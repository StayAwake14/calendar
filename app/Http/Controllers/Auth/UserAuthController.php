<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;
use App\Models\users;

class UserAuthController extends Controller
{
    function login(){
        return view('auth.login');
    }

    function register(){
        return view('auth.register');
    }

    function create(Request $request){
        $request->validate([
            'login'=>'required|unique:users',
            'email'=>'required|email|unique:users',
            'password'=>'required|min:8',
            'rpassword'=>'required|min:8',
            'fname'=>'required',
            'lname'=>'required'
        ]);


        $user = new users;
        $user->login = $request->login;
        $user->password = Hash::make($request->password);
        $user->email = $request->email;
        $user->fname = $request->fname;
        $user->lname = $request->lname;

        if($user->save()){
            return back()->with('success', 'You have been successfully registered!');
        } else{
            return back()->with('fail', 'Something went wrong!');
        }


    }

    function check(Request $request){

        $request->validate([
            'login'=>'required',
            'password'=>'required|min:8'
        ]);

        $user = users::where('login', '=', $request->login)->first();
        if($user)
        {
            if(Hash::check($request->password, $user->password)){
                $request->session()->put('UserLogged', $user->id);
                return redirect('profile');
            } else {
                return back()->with('fail', 'Invaild password!');
            }
        } 
        else
        {
            return back()->with('fail', 'No account found for this login!');
        }

    }

    function profile(){

        if(session()->has('UserLogged')){
            $user = users::where('id', '=', session('UserLogged'))->first();
            $data = [
                'LoggedUserInfo'=>$user
            ];
        }
        return view('admin.profile', $data);
    }

    function logout(){
        if(session()->has('UserLogged')){
            session()->pull('UserLogged');
            return redirect('calendar');
        }
    }

}
