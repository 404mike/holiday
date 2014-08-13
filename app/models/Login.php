<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class Login extends Eloquent implements UserInterface, RemindableInterface {

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

	/**
	 *
	 * @param $tokenType string - type token type, facebook, twitter, google+
	 * @param $token string - token generated from the social network api
	 * @param $id int - user id returned from the social network
	 */
	public static function setSession( $tokenType , $token = '' , $id = '' )
	{
		if($tokenType == 'facebook') {
			$userIdQuery = User::where('facebook_id' , '=' , $id)->first();
			$userId = $userIdQuery->id;
		}

		// Now that we have the user id
		// manually set the authentication against their user id
		$user = User::find($userId);
		Auth::login($user);		
	}

	public function createNewUser( $id , $token )
	{

	}

	/**
	 *
	 * @param $id int facebook user id
	 * @param $token string facebook api access token
	 */
	public static function facebook( $id , $token )
	{
		$tokenExists = Login::where('facebook_id', '=', $id)->count();

		// Check to see if a user has a facebok account
		if($tokenExists > 0) {
			// 'User Exists'
			// Set session
			self::setSession( 'facebook' , $token , $id );
		}else{
			// 'New user'
			
			// check to see if they are already logged in
			// if they are add the facebook data to that account
			// else create a new account
			if (Auth::check()) {

			} else {
				$user = new User;
				$user->facebook_id = $id;
				$user->facebook_oauth = $token;
				$user->save();
			}			
		}
	}

}
