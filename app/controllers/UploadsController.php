<?php

class UploadsController extends \BaseController {

	/**
	 *
	 */
	public function main()
	{
		$data['title'] = 'Create';
		$data['template'] = 'upload/main';		
		return View::make('includes/main', array( 'data' => $data) );		
	}

	/**
	 * Manual fule upload
	 */
	public function createFileUpload( $type='' , $id='' )
	{

		$data['title'] = 'Create';
		$data['template'] = 'create/file';		
		return View::make('includes/main', array( 'data' => $data) );
	}


	/**
	 * Social media upload - facebook, flickr
	 */
	public function createSocialUpload( $type='' , $id='' )
	{

		$data['title'] = 'Create';
		$data['template'] = 'create/main';		
		return View::make('includes/main', array( 'data' => $data) );
	}

	/**
	 *
	 */
	public function postFile()
	{
		Upload::uploadFile($_FILES);
	}

	/**
	 *
	 */
	public function getTweets( $start , $end ) 
	{
		return 'Tweets';
	}

	/**
	 *
	 */
	public function getFacebookFeed( $start , $end ) 
	{
		return 'Facebook';
	}

	/**
	 *
	 */
	public function getLocationData( $lat , $lon ) 
	{
		return 'Geo data';
	}

	/**
	 *
	 */
	public function getWetherData( $date , $location ) 
	{
		return 'Weather';
	}

	/**
	 *
	 */
	public function getAllData() 
	{
		// array to hold a list of all the dates from images
		$date = array();
		// array to hold image data
		$images = array();

		// Loop through the json data and add the dates to the array
		foreach($_POST['images'] as $img) {
			// decode the json response
			$data = json_decode($img);

			// add date information 
			array_push($date, $data->date);

			// add image information
			array_push($images, array(
				'type' 		=> 'image' ,
				'picture' 	=> $data->filename ,
				'blurb' 	=> '' ,
				'created_at'=> date('Y-m-d',$data->date) ,
				'longitude' => $data->lon ,
				'latitude' 	=> $data->lat
				));
		}

		echo '<pre>' , print_r($images) , '</pre>';

		// sort the array
		sort($date , SORT_NUMERIC);

		// timestamp of the first image
		$start = $date[0];
		// timestamp of the last image
		$end = end($date);


		// Twitter
		if(Auth::user()->twitter_id != '') {
			$tweets = Twitter::main( $start , $end );

			echo '<pre>' , print_r($tweets) , ' </pre>';			
		}else {
			$tweets = array();
		}

		// Facebook
		if(Auth::user()->facebook_id != '') {
			$fbFeed = Facebook::feed($start , $end);
			echo '<pre>' , print_r($fbFeed) , ' </pre>';	
		}else{
			$fbFeed = array();
		}
	}

	/**
	 *
	 */
	public function mergeData() 
	{

	}


}
