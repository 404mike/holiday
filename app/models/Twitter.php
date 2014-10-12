<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;
use TwitterOAuth\TwitterOAuth;

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


	public static function main( $start='' , $end='')
	{
		date_default_timezone_set('UTC');

		$start = strtotime('-2 days', $start);
		$end = strtotime('+2 days', $end);		

	    /**
	     * Array with the OAuth tokens provided by Twitter when you create application
	     *
	     * output_format - Optional - Values: text|json|array|object - Default: object
	     */
	    $config = array(
	        'consumer_key' => 'QFlSVjRdHo7mSUyiCpQKmtUD6',
	        'consumer_secret' => 'vJ0n9d8q5pZRzV165ypYtbTpOTNoTNgVplKOkQ2NwjHET3SoiS',
	        'oauth_token' => Auth::user()->twitter_token,
	        'oauth_token_secret' => Auth::user()->twitter_token_secret,
	        'output_format' => 'array'
	    );

	    /**
	     * Instantiate TwitterOAuth class with set tokens
	     */
	    $tw = new TwitterOAuth($config);


	    /**
	     * Returns a collection of the most recent Tweets posted by the user
	     * https://dev.twitter.com/docs/api/1.1/get/statuses/user_timeline
	     */
	    $params = array(
	        // 'screen_name' => 'ricard0per',
	        'count' => 200,
	        'exclude_replies' => true
	    );

	    /**
	     * Send a GET call with set parameters
	     */
	    $response = $tw->get('statuses/user_timeline', $params);

	    $tweets = array();

	    foreach($response as $res) 
	    {
	    	$tweet['created_at'] = strtotime( $res['created_at'] );
	    	$tweet['tweet'] = $res['text'];
	    	$tweet['user'] =  $res['user']['screen_name'];
	    	$tweet['tweed_id'] = $res['id'];
	    	$tweet['type'] = 'tweet';

//	    	Log::info($tweet);

	    	if($tweet['created_at'] > $start && $tweet['created_at'] < $end) {
	    		array_push($tweets, $tweet);
	    	}	    	
	    } 

	    // Log::info($tweets);
	    
	    return $tweets;
	}

}
