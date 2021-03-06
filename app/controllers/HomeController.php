<?php

class HomeController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/

	public function showWelcome()
	{
    	$data['title'] = 'Holiday';
		$data['template'] = 'frontpage/main';
		return View::make('includes/main', array( 'data' => $data) );
	}

	public function welcome()
	{
    	$data['title'] = 'Home';
		$data['template'] = 'home/main';

		$data['stories'] = DBLayer::getUserStories();

		return View::make('includes/main', array( 'data' => $data) );
	}

}
