<?php

class UploadsController extends \BaseController {

	public function upload()
	{
    	$data['title'] = 'Upload';
		$data['template'] = 'upload/main';
		return View::make('includes/main', array( 'data' => $data) );
	}

	public function file()
	{
    	$data['title'] = 'Upload';
		$data['template'] = 'upload/file';
		return View::make('includes/main', array( 'data' => $data) );		
	}

	public function postFile()
	{
		Upload::uploadFile($_FILES);
	}

}
