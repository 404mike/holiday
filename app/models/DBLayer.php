<?php

use Jenssegers\Mongodb\Model as Eloquent;

class DBLayer extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	 protected $collection = 'users_collection';
	 protected $connection = 'mongodb';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password', 'remember_token');

	public static function main()
	{

		$user = new DBLayer;
		$user->name = 'John';
		$user->save();

		return '2342342';
	}

}
