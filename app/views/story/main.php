<?php

	$weather = array(
		'Moderate or heavy snow in area with thunder' => '' ,
		'Patchy light snow in area with thunder' => '' ,
		'Moderate or heavy rain in area with thunder' => '' ,
		'Patchy light rain in area with thunder' => '' ,
		'Moderate or heavy showers of ice pellets' => '' ,
		'Light showers of ice pellets' => '' ,
		'Moderate or heavy snow showers' => '' ,
		'Light snow showers' => '' ,
		'Moderate or heavy sleet showers' => '' ,
		'Light sleet showers' => '' ,
		'Torrential rain shower' => '' ,
		'Moderate or heavy rain shower' => '' ,
		'Light rain shower' => '' ,
		'Ice pellets' => '' ,
		'Heavy snow' => '' ,
		'Patchy heavy snow' => '' ,
		'Moderate snow' => '' ,
		'Patchy moderate snow' => '' ,
		'Light snow' => '' ,
		'Patchy light snow' => '' ,
		'Moderate or heavy sleet' => '' ,
		'Light sleet' => '' ,
		'Moderate or Heavy freezing rain' => '' ,
		'Light freezing rain' => '' ,
		'Heavy rain' => '' ,
		'Heavy rain at times' => '' ,
		'Moderate rain' => '' ,
		'Moderate rain at times' => '' ,
		'Light rain' => 'wi wi-showers' ,
		'Patchy light rain' => '' ,
		'Heavy freezing drizzle' => '' ,
		'Freezing drizzle' => '' ,
		'Light drizzle' => '' ,
		'Patchy light drizzle' => '' ,
		'Freezing fog' => '' ,
		'Fog' => '' ,
		'Blizzard' => '' ,
		'Blowing snow' => '' ,
		'Thundery outbreaks in nearby' => '' ,
		'Patchy freezing drizzle nearby' => '' ,
		'Patchy sleet nearby' => '' ,
		'Patchy snow nearby' => '' ,
		'Patchy rain nearby' => '' ,
		'Mist' => '' ,
		'Overcast' => '' ,
		'Cloudy' => '' ,
		'Partly Cloudy' => 'wi wi-cloudy' ,
		'Clear/Sunny' => '' ,
	);

?>

<h2><?php echo $story->title; ?></h2>

<div id="story_city_details">
	<?php
		$c = json_decode($city , true);
		echo($c['description']);
	?>
</div>

<?php
	if(isset($c['cityName'])) {
		echo '<h3>'.$c['cityName'].'</h3>';
	}
?>

<iframe width="600" height="450" frameborder="0" style="border:0" src="https://www.google.com/maps/embed/v1/place?q=<?php echo $story['mainLoc']; ?>&key=AIzaSyBvF5X5MSWWR5C7QxB96PkcztsJua-OMTY"></iframe>


<?php

$date = '';
$dayCount = 1;

echo '<div class="row">';

foreach($story['items'] as $s => $value)
{
	$v = $value[$s+1];

	if(isset($v['created_at'])) 
	{
		$itemDate = date('Y-m-d' , $v['created_at']);

		if($date == '') {
			echo getItemInfo($v);
			$date = $itemDate;
		}
		elseif($date < $itemDate) {
			$date = $itemDate;
			echo '</div>';

			echo '<div class="story_date">';
			echo '<h2>Day ' . $dayCount . ' - ' . date('l dS F Y', strtotime($date)) . '</h2>';
			
			$dayCount++;

			// echo '<pre>' , print_r($story->weather[$date]) , '</pre>';

			$weatherShort = $story->weather[$date];

			$weatherType = $weatherShort['weatherDesc'][0]['value'];

			echo '<i class="'.$weather[$weatherType].'"></i>';
			echo '<span class="weather_temp">'.$weatherShort['tempC'] . '</span><i class="wi wi-celsius"></i>';
			echo '</div>';


			echo '<div class="row">';
			echo getItemInfo($v);

		}
		else{
			echo getItemInfo($v);
		}
	}else{
		echo getItemInfo($v);
	}
}

echo '</div>';

function getItemInfo( $v )
{
	if($v['display'] == 'false') {
		return;
	}
	if(isset($v['message'])) {
		if($v['message'] == '' ){
			return;
		}		
	}

	$result = 
	' 
	<div class="item">
		<div class="well">
	';

	$type = $v['type'];
	if($type == 'image') {
		$result .= getImageData( $v );
	}
	elseif($type == 'facebookfeed') {
		$result .= getFacebookData( $v );
	}
	elseif($type == 'tweet') {
		$result .= getTweetData( $v );
	}
	elseif($type == 'text') {
		$result .= getTextData( $v );
	}else{
		return '';
	}

	$result .= '
		</div>
	</div>';

	return $result;
}


function getImageData( $v )
{
	if(preg_match('/http(.?)/', $v['picture'])) {
		$img = '<img width=200 src="' . $v['picture'] .'" />';
	}else {
		$img = '<img width=200 src="/photos/' . $v['picture'] .'" />';
	}

	return $img;
}

function getFacebookData( $v )
{
	return $v['message'];
}

function getTweetData( $v )
{
	return $v['message'];
}

function getTextData( $v )
{
	return $v['message'];
}

function getDayWeather( $v )
{

}


