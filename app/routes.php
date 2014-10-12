<?php
use TwitterOAuth\TwitterOAuth;
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

	Route::post('dbpedia' , 'UploadsController@dbpebdia');
});


Route::get('foo' , function(){
    $tw = OAuth::consumer( 'Twitter' );
    $result = json_decode( $tw->request( 'statuses/user_timeline.json?count=20&include_rts=false&exclude_replies=true' ), true );
    echo '<pre>' , print_r($result) , '</pre>';

});	

Route::get('mike' , 'UploadsController@mike');


Route::get('twitter' , function(){






    date_default_timezone_set('UTC');

    // require_once __DIR__ . '/vendor/autoload.php';

    /**
     * Array with the OAuth tokens provided by Twitter when you create application
     *
     * output_format - Optional - Values: text|json|array|object - Default: object
     */
    $config = array(
        'consumer_key' => 'QFlSVjRdHo7mSUyiCpQKmtUD6',
        'consumer_secret' => 'vJ0n9d8q5pZRzV165ypYtbTpOTNoTNgVplKOkQ2NwjHET3SoiS',
        'oauth_token' => '191932900-joKFlukrKvQ8xASWDSp8EyyHSQuxPRxmYIMGHTAZ',
        'oauth_token_secret' => 'zGo7UZpBcT2LZD2bTbE0P5gB7cpZhZW5cFvHxr0lrSgAw',
        'output_format' => 'array'
    );

    /**
     * Instantiate TwitterOAuth class with set tokens
     */
    $tw = new TwitterOAuth($config);


    /**
     * Returns a collection of the most recent Tweets posted by the user
     * https://dev.twitter.com/docs/api/1.1/get/statuses/user_timeline
     */
    $params = array(
        // 'screen_name' => 'ricard0per',
        'count' => 200,
        'exclude_replies' => true
    );

    /**
     * Send a GET call with set parameters
     */
    $response = $tw->get('statuses/user_timeline', $params);

    echo '<pre>' , print_r($response) , '</pre>';


    // /**
    //  * Creates a new list for the authenticated user
    //  * https://dev.twitter.com/docs/api/1.1/post/lists/create
    //  */
    // $params = array(
    //     'name' => 'TwOAuth',
    //     'mode' => 'private',
    //     'description' => 'Test List',
    // );

    // /**
    //  * Send a POST call with set parameters
    //  */
    // $response = $tw->post('lists/create', $params);

    // var_dump($response);


});




