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

Route::get('/', 'HomeController@showWelcome');

Route::get('login', 'LoginController@login');
Route::get('login/facebook', 'LoginController@loginwithFacebook');
Route::get('login/twitter', 'LoginController@loginWithTwitter');
Route::get('logout', 'LoginController@logout');




Route::group(array('before' => 'auth'), function()
{
	Route::get('home', array('before' => 'auth', 'uses' => 'HomeController@welcome'));
	Route::get('account/facebook' , 'AccountsController@facebook');
	Route::get('account/twitter' , 'AccountsController@twitter');

	Route::get('upload/facebookalbums' , 'FacebookController@main');
	Route::get('upload/facebookalbums/next/{next?}' , array('uses' => 'FacebookController@nextAlbum'));

	Route::get('upload' , 'UploadsController@upload');
});


Route::get('photos/{id}' , array('uses' => 'FacebookController@photos'));