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

Route::get('home', array('before' => 'auth', 'uses' => 'HomeController@welcome'));

Route::get('foo' , 'FacebookController@getFacebookLogin');

Route::get('photos/{id}' , array('uses' => 'FacebookController@photos'));





Route::get('test' , function(){

$user = User::find(1);

Auth::login($user);

});

Route::get('fuck' , function(){
	if (Auth::check())
	{
	    echo 'is logged in';
	    echo '<pre>' , print_r(Auth::user()) ,'</pre>';

	}else{
		echo 'not logged in ';
	}
});