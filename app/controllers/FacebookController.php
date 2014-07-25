<?php
session_start();
use Facebook\FacebookSession;
use Facebook\FacebookRequest;
use Facebook\GraphUser;
use Facebook\FacebookRequestException;
use Facebook\FacebookRedirectLoginHelper;



class FacebookController extends \BaseController {

	private $session;

	public function __construct()
	{
		$facebook = FacebookSession::setDefaultApplication('1437671129843796','ca609da430c33464a2c0d56ee60b864e');
		$this->session = new FacebookSession('CAAUbjeTZCiFQBAFcX8Q3JaaqEcqykYXW2GNQuNIKymsaC1C1DfKsJVaCXtmIpmeScKIderp74ZCkoVR5ZCF4HVy8kqzWNKh8MFeg7bZCiQrdMUNt1yUVfJZC8SPlvDxQ8V9lkSdf5XoBD1vKZBiuugFao5gkf3WZCgHtJGByGGC8EZBZB4YxetMSdRQ0xEJh4j69h4ZCTjbD97ZAdCbTWIiiw6v');
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$helper = new FacebookRedirectLoginHelper('http://holiday.dev/index.php/facebook');

		if ($this->session) {
		  self::getFacebookFeed($this->session ,  '');
		}else {
		  echo 'not logged in ';
		  $loginUrl = $helper->getLoginUrl();
		  echo '<a href="'.$loginUrl.'user_photos">Login</a>';
		}

	}

	public function getFacebookLogin()
	{
		// $session->getAccessToken()
		try {
		  $session = $helper->getSessionFromRedirect();
		  echo 'test 1';
		} catch(FacebookRequestException $ex) {
		  // When Facebook returns an error
		  echo 'test 2';
		  echo '<pre>' , print_r($ex) , ' </pre>';
		} catch(\Exception $ex) {
		  // When validation fails or other local issues
		  echo 'test 3';
		  echo '<pre>' , print_r($ex) , ' </pre>';
		}		
	}

	public function getFacebookFeed($session , $after) {

		$user_profile = (new FacebookRequest(
			$this->session, 'GET', '/me/albums'
		))->execute()->getGraphObject();
		
		$album_data =  $user_profile->getProperty('data');

		foreach($album_data->asArray() as $row){
			self::getAlbumCover($this->session , $row->id);
		}
    }

    public function getAlbumCover($session , $id) {
		$album = (new FacebookRequest(
			$this->session, 'GET', "/$id/photos?limit=1"
		))->execute()->getGraphObject();

		$album_data = $album->asArray();

		if(count($album_data) > 0) {
			echo '<div style="border: 1px solid black;
					display: block;
					margin: 20px;
					padding: 10px;
					float:left;
					height:200px;
					overflow:hidden;
					width: 200px;">';
			echo '<a href="/index.php/photos/'.$id.'">' . '<img width="200px" src="'.$album_data['data'][0]->images[2]->source.'" /></a>';
			echo '</div>';
			//echo '************************************';	
		}

    }

    public function photos($id)
    {
		$pictures = (new FacebookRequest(
			$this->session, 'GET', "/$id/photos?limit=500"
		))->execute()->getGraphObject();

		$album_data =  $pictures->getProperty('data');

		echo '<a href="/index.php/facebook" style="display:block;">Back</a>';

		foreach($album_data->asArray() as $row){			
			echo '<div style="border: 1px solid black;
					display: block;
					margin: 20px;
					padding: 10px;
					float:left;
					height:200px;
					overflow:hidden;
					width: 200px;">';
			echo '<img width="200" src="'.$row->images[3]->source.'" />';
			echo '</div>';
		}
    }

}
