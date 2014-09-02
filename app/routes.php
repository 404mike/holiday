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

    $arr = array(

        'mike jones',
        'tom jones',
        'barry smith',
        'john roberts',
        'alex roberts',
        'geoff gilbert',
        'bob thomas',
        'dylan griffith',
        'gareth edwards',
        'andrew jenkins'
    );


    for($i=0;$i<10;$i++){
    $params = array();
        $params['body']  = array(
            'username' => $arr[$i] , 
            'user' => Auth::user()->id ,
            'info' => 'test', 
            'phone' => rand(9000,900000),
            'data' => array(
                'foo' => rand(1,100000),
                'bar' => 'new test'
            )

        );
        $params['index'] = 'holiday';
        $params['type']  = 'holiday';
        $params['id']    = 'fuck'.rand(1,100000);
        $params['timestamp'] = strtotime("-1d");
        $ret = $client->index($params);     
    }


});

Route::get('fetch' , function(){
    $client = new Elasticsearch\Client();

    $params['index'] = 'holiday';
    $params['type']  = 'holiday';
    $params['body']['query']['match']['data.bar'] = 'test';
    // $params['body']['query']['match']['data.foo'] = '82753';

    $results = $client->search($params);

  echo '<pre>' , print_r($results) , '</pre>';

});


Route::get('delete' , function(){
    $client = new Elasticsearch\Client();
    $deleteParams['index'] = 'holiday';
    $client->indices()->delete($deleteParams);
});

Route::get('index' , function(){
        $client = new Elasticsearch\Client();
    $indexParams['index'] = 'holiday';
    $indexParams['body']['settings']['number_of_shards'] = 2;
    $indexParams['body']['settings']['number_of_replicas'] = 0;
    $client->indices()->create($indexParams);

    echo 'sdfsd';
});
Route::get('photos/{id}' , array('uses' => 'FacebookController@photos'));