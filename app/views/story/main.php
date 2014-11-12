<h2><?php echo $story->title; ?></h2>

<div id="story_city_details">
	<?php
		$c = json_decode($city , true);
		echo($c['description'][0]);
	?>
</div>

<?php
	if(isset($c['cityName'])) {
		echo '<h3>'.$c['cityName'].'</h3>';
	}
?>

<iframe width="600" height="450" frameborder="0" style="border:0" src="https://www.google.com/maps/embed/v1/place?q=<?php echo $story['mainLoc']; ?>&key=AIzaSyBvF5X5MSWWR5C7QxB96PkcztsJua-OMTY"></iframe>

<?php
// echo '<pre>' , print_r($story['mainLoc']) , '</pre>';
foreach($story['items'] as $s => $value)
{
	echo '<div class="story_item">';

	if(array_key_exists('type', $value[$s+1])) {
		echo '<h2>Type '.$value[$s+1]['type'].'</h2>';
	}

	if(array_key_exists('message', $value[$s+1])) {
		echo '<p>' . $value[$s+1]['message'] . '</p>';
	}

	if(array_key_exists('picture', $value[$s+1])) {

		if(preg_match('/http(.?)/', $value[$s+1]['picture'])) {
			echo '<img src="' . $value[$s+1]['picture'] .'" />';
		}else {
			echo '<img src="/photos/' . $value[$s+1]['picture'] .'" />';
		}
	}
	
	echo '</div>';
}

?>