<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserTokens extends Model
{
    protected $table = 'tokens';
    protected $guarded = [];
}
