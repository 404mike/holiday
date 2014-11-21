
<form>

<label for="title">Title</label>
<input type="text" id="story_title_edit" name="storyTitle" 
		value="My holiday to <?php if(isset($city['cityName'])) echo $city['cityName'];?>"/>
<input type="hidden" id="story_id_edit" value="<?php echo $story['id']; ?>">
<?php

foreach($story['items'] as $s => $value)
{

	$item = $value[$s+1];
	$itemId = $s+1;

	$storyEdit = '';
	$storyEdit .= '<div class="story_item">';
		$storyEdit .=  '<div class="story_item_container" id="edit_item_'.$itemId.'">';
		// echo '<p>Type: '. $item['type'] . '</p>';
		// echo '<pre>' , print_r($item) , '</pre>';

		if($item['type'] == 'text') {
			$storyEdit .=  '<textarea class="extra_information_area" id="extra_text'.$itemId.'"></textarea>';
		}

		// Message
		if(array_key_exists('message', $item)) {
			$storyEdit .=  '<p>' . $item['message'] . '</p>';
		}

		if(array_key_exists('picture', $item)) {

			if(preg_match('/http(.?)/', $item['picture'])) {
				$storyEdit .=  '<img width=200 src="' . $item['picture'] .'" />';
			}else {
				$storyEdit .=  '<img width=200 src="/photos/' . $item['picture'] .'" />';
			}
		}


		if(isset($item['place'])) {
			$storyEdit .=  '@ ' . $item['place']['name'] . ' ' . $item['place']['city'];
		}

		$storyEdit .=  '</div>';
		// end container	

		$storyEdit .=  '<span id="hide_item_'.$itemId.'" class="hide_story">Hide</span>';
		$storyEdit .=  '<span id="show_item_'.$itemId.'" class="show_story">Show</span>';
		$storyEdit .=  '<div class="clear"></div>';

		
	$storyEdit .=  '</div>';
	// end story
	echo $storyEdit;

}

?>
<div id="finish_edit">Finish</div>
</form>