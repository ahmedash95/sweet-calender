<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;

class AccountSetttingsController extends Controller
{
    public function index(){
        $user = Auth::user();
        $user->load('tokens');
    	return view('account.index',[
    	    'user' => $user,
        ]);
    }
    public function getThirdParties(){
        $user = Auth::user();
        $user->load('tokens');
        return view('account.third-parties',[
            'user' => $user,
        ]);
    }

    public function getTelegramToken(){
        $user = Auth::user();
        $token = Redis::get("user:{$user->id}:token");
        $title = "Telegram Activation Code";
        $message = "Your Code is : ".$token;
        if(!$token){
            $message = "Your token is expierd ask our bot to register you again";
        }
        return view('account.message',[
            'title' => $title,
            'message' => $message,
        ]);
    }
}
