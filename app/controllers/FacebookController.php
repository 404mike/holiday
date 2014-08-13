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
		$this->session = new FacebookSession('CAAUbjeTZCiFQBAK3eaWjFyEjCQlUwgWCXYs2BHZCdhzz6ZCfBT9o2Us3pjJhZC8DpkIrzFnE6lLv3KqgazwNpS0ZBTi8HaelE0BTbtEUUZBtRBn3DIv4AtsfksKK08xNETmG0tgZC9WOEHrPW8N1c7XAFbo2fdC7Dybfqich2Ie0c9ZAYVKbswZAJkynSI0gz0qieRoeORekfyHbpbFLp7Edx');
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
		$helper = new FacebookRedirectLoginHelper('http://holiday.dev/foo');
		// $session->getAccessToken()

       // $helper = new FacebookRedirectLoginHelper('http://test.dev/index.php/facebook');

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
        if ($session) {
          // Logged in
          echo 'logged in';

          print_r($session->getAccessToken());


        }else {
          echo 'not logged in ';
          $loginUrl = $helper->getLoginUrl();
          echo '<a href="'.$loginUrl.'user_photos">Login</a>';
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

			//echo '<pre>' , print_r($album_data['data'][0]->place) , '</pre>';


			echo '<div style="border: 1px solid black;
					display: block;
					margin: 20px;
					padding: 10px;
					float:left;
					height:200px;
					overflow:hidden;
					width: 600px;">';
			if(isset($album_data['data'][0]->place)) {
				echo '<pre>' , print_r($album_data['data'][0]->place) , '</pre>';
			}
			//echo '<a href="/photos/'.$id.'">' . '<img width="200px" src="'.$album_data['data'][0]->images[2]->source.'" /></a>';
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


			echo '<pre>' , print_r($row) ,'</pre>';
			echo '<div style="border: 1px solid black;
					display: block;
					margin: 20px;
					padding: 10px;
					float:left;
					height:200px;
					overflow:hidden;
					width: 200px;">';
			echo $row->created_time;
			echo '<img width="200" src="'.$row->images[3]->source.'" />';
			echo '</div>';
		}
    }

    public function test()
    {
    	$data['title'] = 'Welcome to Musicianado';
		$data['template'] = 'live/main';
		return View::make('includes/main', array( 'data' => $data) );
    }

    /**
 * Login user with facebook
 *
 * @return void
 */

public function loginWithFacebook() {

    // get data from input
    $code = Input::get( 'code' );

    // get fb service
    $fb = OAuth::consumer( 'Facebook' );

    // check if code is valid

    // if code is provided get user data and sign in
    if ( !empty( $code ) ) {

        // This was a callback request from facebook, get the token
        $token = $fb->requestAccessToken( $code );

        echo "Token ";

        $token = (Array) $token;

        $accessToken = '';

        foreach ($token as $obj => $val) {
        	$accessToken = $val;
        	break;
        	//echo '<pre>' , print_r($val) , '</pre>';
        }

        echo "accessToken $accessToken";


        // Send a request with it
        $result = json_decode( $fb->request( '/me' ), true );

        // $message = 'Your unique facebook user id is: ' . $result['id'] . ' and your name is ' . $result['name'];
        // echo $message. "<br/>";

        //Var_dump
        //display whole array().
       // echo '<pre>' , print_r($result) , '</pre>';

    }
    // if not ask for permission first
    else {
        // get fb authorization
        $url = $fb->getAuthorizationUri();

        // return to facebook login url
         return Redirect::to( (string)$url );
    }

	}

}
