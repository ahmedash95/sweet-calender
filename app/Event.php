<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Event extends Model
{
    protected $guarded = [];

    public function calender(){
        return $this->belongsTo(Calender::class);
    }

    public function scopeUser($q){
        return $q->where('user_id',Auth::user()->id);
    }
}
