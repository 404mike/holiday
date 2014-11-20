

<form>

<label for="title">Title</label>



<input type="text" id="title" name="storyTitle" 
		value="My holiday to <?php if(isset($city['cityName'])) echo $city['cityName'];?>"/>

<?php

foreach($story['items'] as $s => $value)
{

	$item = $value[$s+1];
	$itemId = $s+1;
	echo '<div class="story_item">';
		echo '<div class="story_item_container" id="edit_item_'.$itemId.'">';
		// echo '<p>Type: '. $item['type'] . '</p>';
		// echo '<pre>' , print_r($item) , '</pre>';

		if($item['type'] == 'text') {
			echo '<textarea class="extra_information_area" id="extra_text'.$itemId.'"></textarea>';
		}

		// Message
		if(array_key_exists('message', $item)) {
			echo '<p>' . $item['message'] . '</p>';
		}

		if(array_key_exists('picture', $item)) {

			if(preg_match('/http(.?)/', $item['picture'])) {
				echo '<img width=200 src="' . $item['picture'] .'" />';
			}else {
				echo '<img width=200 src="/photos/' . $item['picture'] .'" />';
			}
		}


		if(isset($item['place'])) {
			echo '@ ' . $item['place']['name'] . ' ' . $item['place']['city'];
		}

		echo '</div>';

		echo '<span id="hide_item_'.$itemId.'" class="hide_story">Hide</span>';
		echo '<span id="show_item_'.$itemId.'" class="show_story">Show</span>';
		echo '<div class="clear"></div>';

		// end container	
	echo '</div>';
	// end story
}

?>

</form>