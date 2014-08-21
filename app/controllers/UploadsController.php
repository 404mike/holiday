<?php

class UploadsController extends \BaseController {

	public function upload()
	{
    	$data['title'] = 'Upload';
		$data['template'] = 'upload/main';
		return View::make('includes/main', array( 'data' => $data) );
	}

}
