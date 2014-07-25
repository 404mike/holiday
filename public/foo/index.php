<?php

error_reporting(-1);

require_once('autoload.php');

session_start();

require_once( 'Facebook/FacebookSession.php' );
require_once( 'Facebook/FacebookRedirectLoginHelper.php' );
require_once( 'Facebook/FacebookRequest.php' );
require_once( 'Facebook/FacebookResponse.php' );
require_once( 'Facebook/FacebookSDKException.php' );
require_once( 'Facebook/FacebookRequestException.php' );
require_once( 'Facebook/FacebookAuthorizationException.php' );
require_once( 'Facebook/GraphObject.php' );

use Facebook\FacebookSession;
use Facebook\FacebookRedirectLoginHelper;
use Facebook\FacebookRequest;
use Facebook\FacebookResponse;
use Facebook\FacebookSDKException;
use Facebook\FacebookRequestException;
use Facebook\FacebookAuthorizationException;
use Facebook\GraphObject;


$id = 'xxx';
$secret = 'xxx';

// init app with app id (APPID) and secret (SECRET)
FacebookSession::setDefaultApplication('1437671129843796','ca609da430c33464a2c0d56ee60b864e');

$helper = new FacebookRedirectLoginHelper('http://holiday.dev/index.php/facebook');

try {
  $session = $helper->getSessionFromRedirect();
  echo 'test 1';
} catch(FacebookRequestException $ex) {
  // When Facebook returns an error
  echo 'test 2';
  print_r($ex);
} catch(\Exception $ex) {
  // When validation fails or other local issues
  echo 'test 3';
  print_r($ex);
}
if ($session) {
  // Logged in
  echo 'logged in';
}else {
  echo 'not logged in ';
  $loginUrl = $helper->getLoginUrl();
  echo '<a href="'.$loginUrl.'">Login</a>';
}

echo 'test';