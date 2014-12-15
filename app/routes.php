<?php
use Facebook\FacebookSession;
use Facebook\FacebookRequest;
use Facebook\GraphUser;
use Facebook\FacebookRequestException;
use Facebook\FacebookRedirectLoginHelper;


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
	Route::get('home', 'HomeController@welcome');
	Route::get('account/facebook' , 'AccountsController@facebook');
	Route::get('account/twitter' , 'AccountsController@twitter');

	Route::get('newstory' , 'UploadsController@main');

	/* Facebook uploads */
	Route::get('newstory/facebookalbums' , 'FacebookController@main');
	Route::get('newstory/facebookalbums/album/{id}' , 'FacebookController@album');
	Route::get('newstory/facebookalbums/next/{next?}' , array('uses' => 'FacebookController@nextAlbum'));

	Route::get('create' , 'UploadsController@createFileUpload');
	// Route::get('create/{type?}/{id?}' , 'UploadsController@createSocialUpload');
	Route::get('create/{id?}' , 'UploadsController@editStory');

	Route::get('story/{id?}/delete' , 'UploadsController@deleteStory');

	Route::post('update' , 'UploadsController@updateStory');

	Route::post('fileinfo' , 'UploadsController@getAllData');

	Route::post('upload/file/post' , 'UploadsController@postFile');

	Route::post('dbpedia' , 'UploadsController@dbpebdia');
});

Route::get('user/{id?}' , 'UserController@outBountProfile');

Route::get('story/{id?}' , 'StoryController@getStory');


Route::get('db' , 'MongoController@main');

Route::get('bar' , function(){

	$context = stream_context_create(array('http' => array(
      'header' => 'Accept: application/rdf+xml, text/rdf+xml, text/xml;q=0.1, application/xml;q=0.1, text/plain;q=0.1',
  	)));
// http://dbpedia.org/resource/Buk,_Lesser_Poland_Voivodeship
  	$uriResult = file_get_contents('http://dbpedia.org/resource/Aberystwyth' , false , $context);
  	// print_r($uriResult);

$xml = simplexml_load_string($uriResult);
$json = json_encode($xml);
$array = json_decode($json,TRUE);

print_r($uriResult);

});
// Route::post('update' , function(){
// 	$data = Input::get('info');
// 	Log::info($data);
// });
