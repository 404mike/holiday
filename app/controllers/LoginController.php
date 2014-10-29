<?php

session_start();
use Facebook\FacebookSession;
use Facebook\FacebookRequest;
use Facebook\GraphUser;
use Facebook\FacebookRequestException;
use Facebook\FacebookRedirectLoginHelper;

class LoginController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
	}

	public function login()
	{
    	$data['title'] = 'Login';
		$data['template'] = 'login/login';
		return View::make('includes/main', array( 'data' => $data) );
	}

	public function logout()
	{
    	$data['title'] = 'Logout';
		$data['template'] = 'login/logout';
		return View::make('includes/main', array( 'data' => $data) );
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function loginwithFacebook()
	{
	    // get data from input
	    $code = Input::get( 'code' );

	    // get fb service
	    $fb = OAuth::consumer( 'Facebook' );

	    // check if code is valid

	    // if code is provided get user data and sign in
	    if ( !empty( $code ) ) {

	        // This was a callback request from facebook, get the token
	        $token = $fb->requestAccessToken( $code );

	        $accessToken = $token->getAccessToken();

	        $result = json_decode( $fb->request( '/me' ), true );

	        $fb = Login::facebook( $result['id'] , $accessToken );

	        return Redirect::to('home');
	    }
	    // if not ask for permission first
	    else {
	        // get fb authorization
	        $url = $fb->getAuthorizationUri();

	        // return to facebook login url
	         return Redirect::to( (string)$url );
	    }
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function loginWithTwitter() {

	    // get data from input
	    $token = Input::get( 'oauth_token' );
	    $verify = Input::get( 'oauth_verifier' );

	    // get twitter service
	    $tw = OAuth::consumer( 'Twitter' );

	    // check if code is valid

	    // if code is provided get user data and sign in
	    if ( !empty( $token ) && !empty( $verify ) ) {

	        // This was a callback request from twitter, get the token
	        $token = $tw->requestAccessToken( $token, $verify );

	        $accessTokenSecret = $token->getAccessTokenSecret();

	        $accessToken = $token->getAccessToken();

	        // Send a request with it
	        $result = json_decode( $tw->request( 'account/verify_credentials.json' ), true );

	       	$twitter = Login::twitter( $result['id'] , $accessToken  , $accessTokenSecret);

	        return Redirect::to('home');
	    }
	    // if not ask for permission first
	    else {
	        // get request token
	        $reqToken = $tw->requestRequestToken();

	        // get Authorization Uri sending the request token
	        $url = $tw->getAuthorizationUri(array('oauth_token' => $reqToken->getRequestToken()));

	        // return to twitter login url
	        return Redirect::to( (string)$url );
	    }
	}

}
