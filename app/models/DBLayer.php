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

	public static function saveFeed( $data  , $start , $end )
	{
		$story = new DBLayer;
		$story->user = Auth::user()->id;
		$story->title = '';

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

		$story->cover = '';

		$story->weather = self::getWeather( $data['singleLocation'] , $start , $end );

		$story->save();

		$id = $story->id; 
		// Log::info('complete');
		// Log::info($id);

		return $id;
	}

	public static function saveDbpedia( $storyId , $city )
	{
		$story = DBLayer::where('_id', $storyId)->update(array('dbpedia' => $city));
		// Log::info('city ' . $city . ' story ' . $storyId);
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

		// Log::info($id);
		// Log::info()

		return $stories;
	}

	private static function getWeather( $location , $start , $end )
	{
		$startDate = date('Y-m-d', $start);
		$endDate = date('Y-m-d', $end);

		$key = '67bc347696eb92f485cc30c1891c2';

		$url = 'http://api.worldweatheronline.com/free/v2/past-weather.ashx?q='.$location.'&format=json&date='.$startDate.'&enddate='.$endDate.'&key='.$key;

		// Log::info('Location '. $location);
		// Log::info('start ' . $startDate);
		// Log::info('end ' . $endDate);
		// Log::info('url ' . $url);

		$res = file_get_contents($url);

		$json = json_decode($res , true);

		$weather = array();

		foreach($json['data']['weather'] as $j) {
			$weather[$j['date']] = $j['hourly'][4];
		}

		return $weather;
	}


	public static function updateStory( $details )
	{
		$arr = array();
		$id = $details['id'];
		$arr['title'] = $details['title'];
		// Log::info('title ' . $details['title']);
		// Log::info('id ' . $id);
		// $foo['items.0.1.message'] = 'hello wordl';

		foreach($details['items'] as $item => $value) {
			Log::info('value ' . $item);
			Log::info($value);

			$itemId = $item - 1;

			Log::info('new id ' . $itemId);

			$arr["items.$itemId.$item.display"] = $value['display'];
			if(isset($value['message'])) {
				$arr["items.$itemId.$item.message"] = $value['message'];
			}
		}

		Log::info($arr);

		$story = DBLayer::where('_id', $id)->update($arr, array('upsert' => true));
	}
}
