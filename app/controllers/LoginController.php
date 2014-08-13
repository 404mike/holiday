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
	public function facebook()
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

	        $token = (Array) $token;

	        $accessToken = '';

	        foreach ($token as $obj => $val) {
	        	$accessToken = $val;
	        	break;
	        }

	        //echo "accessToken $accessToken";
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
	public function twitter()
	{
    	$data['title'] = 'Login with Twiiter';
		$data['template'] = 'login/twitter';
		return View::make('includes/main', array( 'data' => $data) );
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}


}
