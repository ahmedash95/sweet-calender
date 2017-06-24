<?php

namespace App;

use App\Contracts\GoogleUpdateToken;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Redis;

class User extends Authenticatable implements GoogleUpdateToken
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function calender(){
        return $this->hasOne(Calender::class);
    }

    public function tokens(){
        return $this->hasMany(UserTokens::class);
    }

    public function getExpireTimeFor($driver){
        return $this->tokens->where('driver',$driver)->first()->expires_in;
    }

    public function hasTokenFor($driver){
        return $this->tokens->where('driver',$driver)->count() > 0;
    }

    public function getTokenFor($driver){
        return $this->tokens->where('driver',$driver)->first()->access_token;
    }

    public function getRefreshTokenFor($driver){
        return $this->tokens->where('driver',$driver)->first()->refresh_token;
    }

    public function removeTokenFor($driver){
        $row = $this->tokens->where('driver',$driver)->first();
        return $row ? $row->delete() : false;
    }

    public function updateDriver($driver,$data){
        $this->tokens()->whereDriver($driver)->firstOrFail()->update($data);
    }

    public function updateGoogleToken($token)
    {
        $this->updateDriver('google',[
            'access_token' => $token['access_token'],
            'refresh_token' => $token['refresh_token'],
            'expires_in' => $token['expires_in'],
        ]);
    }

    public function getTelegramId(){
        return Redis::get("user:{$this->id}:telegram");
    }

    public static function findByTelegramId($id){
        $keys = Redis::keys('user:*:telegram');
        $users = collect($keys)->combine(Redis::mget(...$keys));
        $key = $users->search($id);
        if(!$key) return null;
        $id = str_replace(['user:',':telegram'],'',$key);
        return static::find($id);
    }
}
