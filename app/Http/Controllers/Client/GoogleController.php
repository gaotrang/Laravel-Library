<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    public function redirect(){
        return Socialite::driver('google')->redirect();

    }

    public function callback(){
        $googleUser = Socialite::driver('google')->user();
        $user = User::updateOrCreate(
            ['email' => $googleUser->email],
            [
                'email' => $googleUser->email,
                'name' => $googleUser->name,
                'google-user-id' => $googleUser->id,
                'password' => Hash::make('password' . '@' . $googleUser->id)
            ]
            );

        Auth::login($user);
        return redirect()->route('home');
    }
}
