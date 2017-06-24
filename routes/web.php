<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Notifications\SendTelegramNotification;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/settings','AccountSetttingsController@index');

Route::get('/third-parties','AccountSetttingsController@getThirdParties');
Route::get('/third-parties/google','ThirdPartiesController@getGoogle');
Route::get('/third-parties/google/callback','ThirdPartiesController@handleGoogle');
Route::post('/third-parties/google/remove ','ThirdPartiesController@removeGoogle');

Route::get('/settings/calender','AccountCalenderSettings@index');
Route::post('/settings/calender','AccountCalenderSettings@update');

Route::get('/settings/telegram/token','AccountSetttingsController@getTelegramToken');

Route::resource('/events','EventsController');