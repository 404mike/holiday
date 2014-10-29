<?php

use Jenssegers\Mongodb\Model as Eloquent;

class DBLayer extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	 protected $collection = 'story';
	 protected $connection = 'mongodb';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password', 'remember_token');

	public static function main()
	{

		// $story = new DBLayer;
		// $story->user = rand(1,300);
		// $story->postTitle = 'New York';
		// $story->dbpedia = rand(1,234);
		// $story->items = array(
		// 	0 => array(
		// 		'display' => true ,
		// 		'id' => rand(1,200) ,
		// 		'type' => 'facebook' ,
		// 		'message' => 'test' ,
		// 		'created_at' => 12312312312,
		// 		'place' => array (
		// 	        'name' => 'Clubhouse Virgin Atlantic',
		// 	        'city' => 'Heathrow',
		// 	        'country' => 'United Kingdom',
		// 	        'latitude' => 51.470356674519998,
		// 	        'longitude' => -0.46083979519515,
		// 	      ),
		// 	),
		// 	1 => array(
		// 		'display' => false ,
		// 		'id' => rand(1,200) ,
		// 		'type' => 'tweet' ,
		// 		'message' => 'test 23423' ,
		// 		'created_at' => 12312312312
		// 	)
		// );

		// $story->items = array(
		// 	4 => array('foo' => 'bar')
 	// 	);

		// echo '<pre>' , print_r($story) , '</pre>';

		// $story->save();

		// echo "<h2>ID " . $story->id . "</h2>";

		$foo = DBLayer::where('_id', '=', '5451407e279871061e8b4567')->get();


		echo '<pre>' , print_r($foo) , '</pre>';

		return;
	}

	public static function saveFeed( $data )
	{
		$story = new DBLayer;
		$story->user = Auth::user()->id;
		$story->title = 'New York';

		$story->dbpedia = '';

		$items = array();

		$loop = 1;

		// add the first item to the array
		array_push($items, array(
			$loop => array(
				'message' => '',
				'display' => 'true'
			)
		));	

		foreach($data['data'] as $d => $value)
		{
			// unset fields
			if(array_key_exists('longitude', $value)) {
				unset($value['longitude']);
			}

			if(array_key_exists('latitude', $value)) {
				unset($value['latitude']);
			}

			$loop++;

			array_push($items, array(
				$loop => $value
			));

			$loop++;

			array_push($items, array(
				$loop => array(
					'message' => '',
					'display' => 'true'
				)
			));			
		}

		$story->items = $items;

		$story->mainLoc = $data['singleLocation'];

		$story->likes = '';

		$story->save();

		$id = $story->id; 

		Log::info($id);

	}

}
