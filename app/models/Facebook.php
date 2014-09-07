<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class Facebook extends Eloquent implements UserInterface, RemindableInterface {

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

	public static function feed( $start='' , $end='' )
	{
		$start = strtotime('-2days', $start);
		$end = strtotime('+2 days', $end);
		$fb = OAuth::consumer( 'Facebook' );
		// Log::info('/me/feed?fields=message,picture&since='.$start.'&until='.$end.'&limit=200');
		$result = json_decode( 
			$fb->request( '/me/feed?fields=message,picture,place&since='.$start.'&until='.$end.'&limit=200' ), 
			true );
		
		$feed = array();

		foreach($result['data'] as $res){
			if(isset($res['message'])) {
				$fb = array();
				$fb['type'] = 'facebookfeed';
				$fb['message'] = $res['message'];
				if(isset($res['picture'])) {
					$fb['picture'] = $res['picture'];
				}				
				$fb['created_at'] = strtotime($res['created_time']);
				if(isset($res['place'])){
					$fb['place'] = $res['place'];
				}

				//echo '<pre>' , print_r($res) , '</pre>';

				array_push($feed, $fb);
			}
		}

		// Log::info($result);

		return $feed;
	}

}

