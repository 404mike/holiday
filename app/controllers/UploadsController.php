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
	public function mergeData() 
	{
		sleep(3);
		return 'hello world';
	}

}
