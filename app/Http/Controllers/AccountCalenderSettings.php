<?php

namespace App\Http\Controllers;

use App\Services\GoogleCalender;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccountCalenderSettings extends Controller
{
    public function index(GoogleCalender $calender){
        $currentCalenderId = Auth::user()->calender->calender_id ?? null;
        $calenderList = $calender->getCalendersList();
        return view('account.calender',[
            'calenderList' => $calenderList,
            'current_calender_id' => $currentCalenderId,
        ]);
    }

    public function update(Request $request,GoogleCalender $calender){
        $calenderItem = $calender->findById($request->input('calender'));
        Auth::user()->calender()->updateOrCreate([
            'user_id' => Auth::user()->id,
        ],[
           'name' => $calenderItem['name'],
           'calender_id' => $request->input('calender'),
        ]);
        return back();
    }
}
