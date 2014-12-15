<h2>Welcome</h2>

<?php
if(Session::has('success')) {
	echo Session::get('success');
}
?>


<?php

if(Auth::user()->facebook_id == '') {
	echo '<a href="/account/facebook" class="btn-lg btn btn-block btn-social btn-facebook"><i class="fa fa-facebook"></i> Connectwith Facebook</a>';
}
if(Auth::user()->twitter_id == '') {
	echo '<a href="/account/twitter" class="btn-lg btn btn-block btn-social btn-twitter"><i class="fa fa-twitter"></i> Connect with Twitter</a>';
}
// if(Auth::user()->google_oauth == '') {
// 	echo '<a href="/account/google" class="btn-lg btn btn-block btn-social btn-google-plus"><i class="fa fa-google-plus"></i> Connect with Google</a>';
// }




echo '<h3>'.count($stories).' Stories</h3>';
// echo '<pre>' , print_r($stories) , '</pre>';
foreach( $stories as $story) {
	// echo '<pre>' , print_r($story) , '</pre>';

	if($story->title == '') {
		$title = 'New Story';
	}else{
		$title = $story->title;
	}

	echo '<a class="home-story-item" href="story/'.$story->id.'">'.$title.'</a>';
}