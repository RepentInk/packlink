<?php

namespace App\Http\Controllers;

use App\User;
use Exception;
use Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Socialite;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    /**
     * Pages
    */
    public function signupPage(){
       return view('pages.signup');
    }

    /**
     * Actions
     *
    */
    public function saveUser(Request $request){

        $validate = Validator::make($request->all(), [
            'name' => 'required|string|min:2',
            'email' => 'email|unique:users,email|nullable',
            'password' => 'required|min:6',
            'confirm_password' => 'required|min:6|same:password',
        ]);

        if ($validate->fails()) {
            return response()->json(['error' => $validate->errors()], 422);
        }


        try{

            $user = new User();
            $user->nickname = $request['name'];
            $user->name = $request['name'];
            $user->email = $request['email'];
            $user->user_type = "user";
            $user->password = bcrypt($request['password']);
            $user->profile = 'avatar.png';

            $user->save();

            Auth::login($user, true);

            return $user->user_type;

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 402);
        }

    }

    public function loginUser(Request $request){
        if(Auth::attempt(['email'=>$request->email, 'password'=>$request->password], true)) {
            return Auth::user()->user_type;
        } else {
            return response()->json(['error' => 'Invalid Login Credentials'], 422);
        }
    }

    public function github(){
       return Socialite::driver('github')->redirect();
    }

    public function githubRedirect()
    {
       try {

        $user = Socialite::driver('github')->user();

        if($user->nickname == null){
            $nickname = $user->name;
        } else {
            $nickname = $user->nickname;
        }

        if($user->name == null){
            $name = $user->nickname;
        } else {
            $name = $user->name;
        }

        $user = User::firstOrCreate([
            'email' => $user->email
        ],[
          'nickname' => $nickname,
          'name' => $name,
          'password' => Hash::make(Str::random(24)),
          'profile' => 'avatar.png',
          'user_type' => 'user',
        ]);

        Auth::login($user, true);

        return redirect('/dashboard');

       } catch(Exception $e){
          return response()->json(['error' => $e->getMessage()], 402);
       }
    }


    public function google()
    {
        return Socialite::driver('google')->redirect();
    }


    public function googleRedirect()
    {
        try {

         $user = Socialite::driver('google')->user();

         if($user->nickname == null){
           $nickname = $user->name;
         } else {
            $nickname = $user->nickname;
         }

         if($user->name == null){
            $name = $user->nickname;
         } else {
            $name = $user->name;
         }

         $user = User::firstOrCreate([
             'email' => $user->email
         ],[
           'nickname' => $nickname,
           'name' => $name,
           'password' => Hash::make(Str::random(24)),
           'profile' => 'avatar.png',
           'user_type' => 'user',
         ]);

         Auth::login($user, true);

         return redirect('/dashboard');

        } catch(Exception $e){
           return response()->json(['error' => $e->getMessage()], 402);
        }
    }


    public function logout()
    {
        Auth::logout();
        return redirect()->route('index');
    }

}
