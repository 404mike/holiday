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

	Route::get('newstory' , 'UploadsController@main');

	/* Facebook uploads */
	Route::get('newstory/facebookalbums' , 'FacebookController@main');
	Route::get('newstory/facebookalbums/album/{id}' , 'FacebookController@album');
	Route::get('newstory/facebookalbums/next/{next?}' , array('uses' => 'FacebookController@nextAlbum'));

	Route::get('create' , 'UploadsController@createFileUpload');
	Route::get('create/{type?}/{id?}' , 'UploadsController@createSocialUpload');

	Route::post('fileinfo' , 'UploadsController@getAllData');

	Route::post('upload/file/post' , 'UploadsController@postFile');
});


Route::get('foo' , function(){

	$arr = [
		'52.416091, -4.080259',
		'51.481303, -0.456359',
		'51.495893, -0.457115',
		'40.749601, -73.987273',
		'40.747390, -73.997573',
		'40.726188, -74.004096',
		'40.715000, -74.009933',
		'40.645483, -74.078425',
		'40.709366, -73.953075',
		'40.784015, -73.953075'
	];

	$locations = [];
	$hourly = [];

	foreach($arr as $a) {
		$geo = explode(',', $a);
		$lat = round($geo[0],1);
		$lng = round($geo[1],1);

		if(array_key_exists($lat.','.$lng, $locations)){
			$locations[$lat.','.$lng] += 1;
		}else{
			$locations[$lat.','.$lng] = 1;
		}		
	}

	$highestNum = max($locations);
	$key = array_search($highestNum, $locations); 
	$keyLatLng = explode(',', $key);
	$lat = $keyLatLng[0];
	$lng = $keyLatLng[1];

	foreach($arr as $a) {
		if(preg_match('/'.$lat.'(.*), '.$lng.'(.*)/', $a)) {
			return $a;
		}
	}

});