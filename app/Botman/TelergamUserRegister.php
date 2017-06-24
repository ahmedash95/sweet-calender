<?php

namespace App\Botman;


use App\User;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Str;
use Mpociot\BotMan\Answer;
use Mpociot\BotMan\Conversation;

class TelergamUserRegister extends Conversation
{
    private $email;
    private $user;

    public function run(){
        $this->askForEmail();
    }

    private function askForEmail()
    {
        $this->ask('What\'s your email ?',function (Answer $answer){
            $this->email = $answer->getText();
            $this->user = User::where('email',$this->email)->first();
            if(!$this->user){
                $this->say('Sorry but I couldn\'t find your email in the system');
                $this->bot->typesAndWaits(1);
                return $this->askForEmail();
            }
            $token = $this->generateTokenForUser($this->user);
            $this->askForToken($token,$this->user);
        });
    }

    private function generateTokenForUser($user)
    {
        $token = Str::random(5);
        Redis::set("user:{$user->id}:token", $token, 'EX', 300); // 5 min
        return $token;
    }

    private function askForToken($token,$user)
    {
        $url = url('/settings/telegram/token');
        $this->ask("Please open this url [{$url}] and give me the token",function(Answer $answer) use ($token,$user) {
            $userToken = $answer->getText();
            if($token != $userToken){
                $this->say("Your provided token is invalid !");
            } else {
                Redis::set("user:{$user->id}:telegram",$this->bot->getUser()->getId());
                $this->say("Your account now is connecting to our bot");
                $this->say("Your will get notifications for any event at time.");
            }
        });
    }
}