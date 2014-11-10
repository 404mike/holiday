<?php

class StoryController extends Controller {

	public function getStory( $id )
	{
    	$data['title'] = 'Holiday';
		$data['template'] = 'story/main';
		$data['id'] = $id;
		$data['story'] = DBLayer::getStory( $id );
		// echo '<pre>' , print_r($data['story']) , '</pre>';
		return View::make('includes/main', array( 'data' => $data) );
	}

}