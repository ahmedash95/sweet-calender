<?php
/**
 * Created by PhpStorm.
 * User: Ash
 * Date: 6/23/17
 * Time: 6:45 PM
 */

namespace App\Contracts;


interface GoogleUpdateToken
{
    public function updateGoogleToken($token);
}