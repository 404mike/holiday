
<?php 


	foreach($stories as $story)
	{
		//echo '<pre>' , print_r($story) , '</pre>';
		echo '<h2><a href="/story/'.$story->_id.'">' . $story->title . '</a></h2>';
	}

?>