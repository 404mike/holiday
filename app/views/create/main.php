

<form>

<label for="title">Title</label>



<input type="text" id="title" name="storyTitle" value="My holiday to <?php if(isset($city['cityName'])) echo $city['cityName'];?>
"/>

<?php

foreach($story['items'] as $s => $value)
{

	$item = $value[$s+1];
	echo '<div class="story_item">';

	// if(array_key_exists('type', $value[$s+1])) {
	// 	// echo '<h2>Type '.$value[$s+1]['type'].'</h2>';
	// }


	// Message
	if(array_key_exists('message', $item)) {
		echo '<p>' . $item['message'] . '</p>';


		// Check to see if there is a location


		// Get type 

		

	}

	if(array_key_exists('picture', $item)) {

		if(preg_match('/http(.?)/', $item['picture'])) {
			echo '<img src="' . $item['picture'] .'" />';
		}else {
			echo '<img src="/photos/' . $item['picture'] .'" />';
		}
	}
	

	echo '<p>Type: '. $item['type'] . '</p>';

	echo '</div>';
}

?>

</form>