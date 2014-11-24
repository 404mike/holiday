

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
// echo '<pre>' , print_r($story['mainLoc']) , '</pre>';

$date = '';
$dayCount = 1;

foreach($story['items'] as $s => $value)
{
	$v = $value[$s+1];

	if(isset($v['created_at'])) {
		// echo '<h2>' . date('Y-m-d' , $v['created_at']) . '</h2>';
		$itemDate = date('Y-m-d' , $v['created_at']);

		if($date == '') {
			$date = $itemDate;
		}
		elseif($date < $itemDate) {
			echo '<h2>Day ' . $dayCount . ' - ' . $date . '</h2>';
			$date = $itemDate;
			$dayCount++;

			// echo '<pre>' , print_r($story->weather[$date]) , '</pre>';
		}
	}

	if( $v['display'] != 'false' ) { //

		if($v['type'] == 'text' && $v['message'] == '') continue;

 		echo '<div class="story_item">';

		if(array_key_exists('type', $v)) {
			echo '<h2>Type '.$v['type'].'</h2>';
		}

		if(array_key_exists('message', $v)) {
			echo '<p>' . $v['message'] . '</p>';
		}

		if(array_key_exists('picture', $v)) {

			if(preg_match('/http(.?)/', $v['picture'])) {
				echo '<img width=200 src="' . $v['picture'] .'" />';
			}else {
				echo '<img width=200 src="/photos/' . $v['picture'] .'" />';
			}
		}
		
		echo '</div>';
	}
}

?>