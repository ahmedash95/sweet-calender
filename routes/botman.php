<?php


use App\Notifications\SendTelegramNotification;

Route::post('/botman',function (){
    $botman = resolve('botman');

    $botman->hears('hi', function($bot){
        $user = $bot->getUser();
        $bot->reply('Hi '.$user->getFirstName());
    });

    $botman->hears('register me',function ($bot){
      $bot->startConversation(new App\Botman\TelergamUserRegister);
    });

    $botman->hears('send test event',function ($bot){
       $user = \App\User::findByTelegramId($bot->getUser()->getId());
       if(!$user){
           return $bot->reply('Sorry but you are not registered , type "register me" to setup your account');
       }
        $bot->reply("Okay {$user->name} I'm on my way :D");
        $user->notify(new SendTelegramNotification("Test Message"));
    });

    $botman->hears('get my username',function ($bot){
        $user = \App\User::findByTelegramId($bot->getUser()->getId());
        if(!$user){
            return $bot->reply('Sorry but you are not registered , type "register me" to setup your account');
        }
        $bot->reply('Your username is : '.$user->name);
    });
    $botman->listen();
});