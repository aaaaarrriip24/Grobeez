<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Exception;
use Auth;

class GoogleController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }
        
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function handleGoogleCallback()
    {
        try {
      
            $user = Socialite::driver('google')->user();

            $findadmin = User::where('google_id', $user->id)
            ->where('roleuser', 'Admin')
            ->first();

            $finduser = User::where('google_id', $user->id)
            ->where('roleuser', 'User')
            ->first();

            if($findadmin){
       
                Auth::login($findadmin);
                return redirect()->intended('home');
       
            } else if($finduser) {

                Auth::login($finduser);
                Auth::logout($finduser);
                return redirect()->intended('/');
                
            } else {

                $newUser = User::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'google_id'=> $user->id,
                    'password' => encrypt('123456dummy'),
                    'roleuser'=> 'User',
                ]);
      
                Auth::logout($newUser);
                return redirect()->intended('/');
            }
      
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }
}
