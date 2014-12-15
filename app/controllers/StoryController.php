<?php

class StoryController extends Controller {

	public function getStory( $id )
	{
    $data['title'] = 'Holiday';
		$data['template'] = 'story/main';
		$data['id'] = $id;
		$data['story'] = DBLayer::getStory( $id );
		// echo '<pre>' , print_r($data['story']) , '</pre>';

		$city = $data['story']->dbpedia;

		$data['city'] = Dbpedia::getCityDetails( $city );

		// echo '<pre>' , print_r($data['city']) , '</pre>';
		return View::make('includes/main', array( 'data' => $data) );
	}

	public function myStories()
	{
	  echo 'test';
	}

}