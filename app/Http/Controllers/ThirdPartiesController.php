<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class ThirdPartiesController extends Controller
{
    public function getGoogle(){
        return Socialite::driver('google')
            ->with(['access_type' => 'offline'])
            ->scopes(['https://www.googleapis.com/auth/calendar'])
            ->redirect();
    }
    public function handleGoogle(){
        $user = Socialite::driver('google')->user();
        Auth::user()->tokens()->updateOrCreate([
            'driver' => 'google',
            'user_id' => Auth::user()->id,
        ],[
            'access_token' => $user->token,
            'refresh_token' => $user->refreshToken ?? "",
            'expires_in' => $user->expiresIn,
        ]);
        return redirect('/third-parties');
    }
    public function removeGoogle(){
        Auth::user()->removeTokenFor('google');
        return back();
    }
}
