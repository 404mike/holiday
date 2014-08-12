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

Route::get('login', 'LoginController@login');
Route::get('login/facebook', 'LoginController@facebook');
Route::get('login/twitter', 'LoginController@twitter');



Route::get('logout', 'LoginController@logout');

Route::get('facebook' , 'FacebookController@loginWithFacebook');

Route::get('photos/{id}' , array('uses' => 'FacebookController@photos'));