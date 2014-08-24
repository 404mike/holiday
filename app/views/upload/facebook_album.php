<?php

//echo '<pre>' , print_R($images) , '</pre>';

foreach($images as $img) {
	echo '<div class="single_fb_photo">';
	echo '<img src="'.$img['image'].'" />';
	if(isset($img['location'])) {
		echo '<span>Location: ' . $img['location'] .'</span>';
	}
	
	echo '<span>Time: ' . $img['created_time'] .'</span>';
 	echo '</div>';
}