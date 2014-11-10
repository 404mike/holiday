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

	public static function main()
	{

		// $book = new DBLayer(array('_id' => '4'));

$foo = DBLayer::where('_id', '4')->get()->first();
// $data = array('dbpedia' => rand(1,987));
// $foo->update($data);

		// // DB::collection('story')->where('_id', 4)->push('items', 'boots');
		// $data = array('dbpedia' , 'mike');
		// $story = DBLayer::where('_id' , '=' , '4')->update($data);

		// // $story = new DBLayer;
		// // $story->user = Auth::user()->id;
		// // $story->_id = '4';
		// // $story->title = 'New York test ' . rand(1, 2343423);
		// // $story->dbpedia = '2323424234';
		// // $story->mainLoc = 'blah';
		// // $story->likes = '';
		// // $story->save();

		// // $id = $story->id; 
		// // echo $id;
		// // $foo = DBLayer::where('_id' , '=' , $id)->get();
		// // $foo->dbpedia = 'sdfs';
		// // $foo->save();

		// $foo = DBLayer::where('_id' , '=' , '4')->get();
		echo '<pre>' , print_r($foo) , ' </pre>';

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
				'message' => '' ,
				'display' => 'true' ,
				'type'	  => 'text'
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
					'message' => '' ,
					'display' => 'true' , 
					'type'	  => 'text'
				)
			));			
		}

		$story->items = $items;

		$story->mainLoc = $data['singleLocation'];

		$story->likes = '';

		$story->save();

		$id = $story->id; 

		// Log::info($id);

		return $id;
	}

	public static function saveDbpedia( $city , $storyId )
	{
		$story = DBLayer::where('_id' , '=' , $storyId);
		$story->dbpedia = $city;
		$story->save();
	}


	public static function getStory( $id )
	{
		$story = DBLayer::where('_id' , '=' , $id)->first();
		return $story;
	}

	public static function getUserStories( $id )
	{
		$id = (int) $id;
		$stories = DBLayer::where('user' , '=' , $id)->get();

		Log::info($id);
		// Log::info()

		return $stories;
	}
}
