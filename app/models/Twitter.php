<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class Twitter extends Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password', 'remember_token');


	public static function main( $start='' , $end='' )
	{    
		$start = strtotime('-2 days', $start);
		$end = strtotime('+2 days', $end);

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
	    	$tweet['type'] = 'tweet';

	    	if($tweet['created_at'] > $start && $tweet['created_at'] < $end) {
	    		array_push($tweets, $tweet);
	    	}	    	
	    } 

	    Log::info($tweets);
	    
	    return $tweets;
	}


}
