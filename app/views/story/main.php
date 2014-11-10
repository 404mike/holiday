<h2><?php echo $story->title; ?></h2>



<?php
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