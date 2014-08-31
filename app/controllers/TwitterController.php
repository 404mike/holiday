<?php

class TwitterController extends \BaseController {

	public static function main( $start='' , $end='' )
	{    
		$tweets = array();
		// get twitter service
	    $tw = OAuth::consumer( 'Twitter' );
	    $result = json_decode( $tw->request( 'statuses/user_timeline.json?count=200&include_rts=false&exclude_replies=true' ), true );

	    foreach($result as $res) 
	    {
	    	$tweet['created_at'] = strtotime( $res['created_at'] );
	    	$tweet['tweet'] = $res['text'];
	    	$tweet['user'] =  $res['user']['screen_name'];
	    	$tweet['tweed_id'] = $res['id'];

	    	if($tweet['created_at'] > $start && $tweet['created_at'] < $end) {
	    		array_push($tweets, $tweet);
	    	}	    	
	    } 
	    
	    return json_encode($tweets);
	}
}