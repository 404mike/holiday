<?php

class UserController extends Controller {

	public function outBountProfile( $id )
	{
    	$data['title'] = 'Holiday';
		$data['template'] = 'user/main';
		$data['id'] = $id;

		$data['stories'] = DBLayer::getUserStories( $id );
		return View::make('includes/main', array( 'data' => $data) );
	}

}