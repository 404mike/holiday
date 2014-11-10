<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;
use Facebook\FacebookSession;
use Facebook\FacebookRequest;
use Facebook\GraphUser;
use Facebook\FacebookRequestException;
use Facebook\FacebookRedirectLoginHelper;


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

    public function __construct()
    {

    }

	public static function feed( $start='' , $end='' )
	{
		$start = strtotime('-2days', $start);
		$end = strtotime('+2 days', $end);

        FacebookSession::setDefaultApplication('1437671129843796','ca609da430c33464a2c0d56ee60b864e');
        $session = new FacebookSession(Auth::user()->facebook_oauth);

        $user_profile = (new FacebookRequest(
            $session, 'GET', '/me/feed?fields=message,picture,place,object_id&since='.$start.'&until='.$end.'&limit=200'
        ))->execute()->getGraphObject();

        $album_data =  $user_profile->getProperty('data');

        $feed = array();

        foreach($album_data->asArray() as $res){

            if(isset($res->message)) {
                $fb = array();
                $fb['id'] = $res->id;
                $fb['type'] = 'facebookfeed';
                $fb['message'] = $res->message;
                $fb['display'] = 'true';

                if(isset($res->picture) && isset($res->object_id)) {
                    // Log::info($res);
                    // Log::info('Calling get picture ' . $res['object_id']);
                    $fb['picture'] = self::getLargeFeedPicture($res->object_id);
                }

                $fb['created_at'] = strtotime($res->created_time);

                if(isset($res->place)){

                    $fb['place']['name'] = $res->place->name;
                    $fb['place']['city'] = $res->place->location->city;
                    $fb['place']['country'] = $res->place->location->country;
                    $fb['place']['latitude'] = $res->place->location->latitude;
                    $fb['place']['longitude'] = $res->place->location->longitude;

                    $fb['loc'] = array($res->place->location->longitude , $res->place->location->latitude);
                }

                //echo '<pre>' , print_r($res) , '</pre>';

                array_push($feed, $fb);
            }
        }

		return $feed;
	}

	public static function getLargeFeedPicture($object_id)
	{
        FacebookSession::setDefaultApplication('1437671129843796','ca609da430c33464a2c0d56ee60b864e');
        $session = new FacebookSession(Auth::user()->facebook_oauth);

        try{
            $user_profile = (new FacebookRequest(
                $session, 'GET', '/'.$object_id
            ))->execute()->getGraphObject();

            $album_data =  $user_profile->asArray();

            return $album_data['images'][0]->source;
        }catch(Exception $e) {
            return '';
        }
	}

}

