<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class Accounts extends Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 *
	 * @param $id int facebook user id
	 * @param $token string facebook api access token
	 */
	public static function facebook( $id , $token )
	{
		// Check to see if the user is already logged in with another account
		if (Auth::check()) {
			$userId = Auth::user()->id;

			$user = User::find($userId);
			$user->facebook_id = $id;
			$user->facebook_oauth = $token;
			$user->save();
		}
	}

	/**
	 *
	 * @param $id int tiwtter user id
	 * @param $token string twitter token
	 * @param $tokenSecret string twitter token secret
	 */
	public static function twitter( $id , $token , $tokenSecret)
	{
		if (Auth::check()) {
			$userId = Auth::user()->id;

			$user = User::find($userId);
			$user->twitter_id = $id;
			$user->twitter_token = $token;
			$user->twitter_token_secret = $tokenSecret;
			$user->save();
		}
	}

}
