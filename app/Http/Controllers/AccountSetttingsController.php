<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
}
