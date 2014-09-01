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
	Route::get('upload/facebookalbums/album/{id}' , 'FacebookController@album');
	Route::get('upload/facebookalbums/next/{next?}' , array('uses' => 'FacebookController@nextAlbum'));


	Route::get('twitter' , 'TwitterController@main');

	Route::get('upload' , 'UploadsController@upload');
	Route::get('upload/file' , 'UploadsController@file');
	Route::post('upload/file/post' , 'UploadsController@postFile');
});

Route::get('data' , function(){
	$client = new Elasticsearch\Client();
	$params = array();
	$params['body']  = array('testField' => 'abc' , 'think' => 'sdfs', 'foo' => array('one'=>'two'));
	$params['index'] = 'my_index';
	$params['type']  = 'my_type';
	$params['id']    = 'my_id';
	$ret = $client->index($params);
});

Route::get('fetch' , function(){
	$client = new Elasticsearch\Client();
    $getParams = array();
    $getParams['index'] = 'my_index';
    $getParams['type']  = 'my_type';
    $getParams['id']    = 'my_id';
    $retDoc = $client->get($getParams);

    echo '<pre>' , print_r($retDoc) , '</pre>';

});

Route::get('photos/{id}' , array('uses' => 'FacebookController@photos'));