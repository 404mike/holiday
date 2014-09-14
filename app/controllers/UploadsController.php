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
			if(isset($data->date) && isset($data->filename)){
				array_push($date, $data->date);

				// add image information
				array_push($images, array(
					'type' 		=> 'image' ,
					'picture' 	=> $data->filename ,
					'blurb' 	=> '' ,
					'created_at'=> $data->date ,
					'longitude' => $data->lon ,
					'latitude' 	=> $data->lat
				));
			}

		}

		// sort the array
		sort($date , SORT_NUMERIC);

		// timestamp of the first image
		$start = $date[0];
		// timestamp of the last image
		$end = end($date);

		// Twitter
		if(Auth::user()->twitter_id != '') {
			$tweets = Twitter::main( $start , $end );	
		}else {
			$tweets = array();
		}

		// Facebook
		if(Auth::user()->facebook_id != '') {
			$fbFeed = Facebook::feed($start , $end);
		}else{
			$fbFeed = array();
		}

		$finalData['data'] = self::mergeData($images , $tweets , $fbFeed);

		// Log::info($finalData);

		$singleLocation = Upload::getSinglelatLng($finalData);

		$finalData['singleLocation'] = $singleLocation;

		return Response::json($finalData);
	}

	/**
	 *
	 */
	public function mergeData( $image , $tweet = '' , $fbFeed = '') 
	{
		$mergeData = array_merge($image , $tweet , $fbFeed);

		usort($mergeData, function($a, $b) {
		    return $a['created_at'] - $b['created_at'];
		});

		return $mergeData;
	}

	public function dbpebdia()
	{
		$cityData = Input::get('city');

		$city = Dbpedia::getDbpediaInformation( $cityData );

		$simpleXml = simplexml_load_string($city);

		return Response::json($simpleXml);
	}

}
