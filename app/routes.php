<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', function()
{
	return View::make('hello');
});

Route::get('login' , function(){
	echo 'login';
});

Route::get('logout' , function(){
	echo 'logout';
});


// Route::get('/{user}/' , function($user) {
// 	echo 'Hello ' . $user;
// });

Route::resource('facebook' , 'FacebookController');

Route::get('photos/{id}' , array('uses' => 'FacebookController@photos'));