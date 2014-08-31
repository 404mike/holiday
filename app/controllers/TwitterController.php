<?php

class TwitterController extends \BaseController {

	public function main()
	{    
		// get twitter service
	    $tw = OAuth::consumer( 'Twitter' );
	    $result = json_decode( $tw->request( 'statuses/user_timeline.json?count=200' ), true );

	    foreach($result as $res) 
	    {
	    	echo '<pre>' , print_r($res['geo']) ,'</pre>';
	    	echo '<pre>' , print_r($res['place']) ,'</pre>';
	    	echo '<pre>' , print_r($res['coordinates']) ,'</pre>';

	    	echo "<br />Created at " . $res['created_at'];
	    	echo "<br />Text " . $res['text'];
	    	echo "<br />User " . $res['user']['screen_name'];
	    	echo "<br />Tweet id " . $res['id'];
	    	echo "<br />Created at " . $res['created_at'];



	    	echo '<br /><br /><br /><br />***************<br /><br /><br /><br />';
	    } 
	    


	}

}



// Array
// (
//     [created_at] => Thu Aug 28 10:17:20 +0000 2014
//     [id] => 504935757719810048
//     [id_str] => 504935757719810048
//     [text] => @OwenTrefonwys @mikefclarke does he even tweet?
//     [source] => Twitter for iPhone
//     [truncated] => 
//     [in_reply_to_status_id] => 504934116408979458
//     [in_reply_to_status_id_str] => 504934116408979458
//     [in_reply_to_user_id] => 243555574
//     [in_reply_to_user_id_str] => 243555574
//     [in_reply_to_screen_name] => OwenTrefonwys
//     [user] => Array
//         (
//             [id] => 191932900
//             [id_str] => 191932900
//             [name] => Mike Jones â˜º
//             [screen_name] => 404mike
//             [location] => 
//             [description] => Technical Officer
//             [url] => 
//             [entities] => Array
//                 (
//                     [description] => Array
//                         (
//                             [urls] => Array
//                                 (
//                                 )

//                         )

//                 )

//             [protected] => 1
//             [followers_count] => 38
//             [friends_count] => 254
//             [listed_count] => 0
//             [created_at] => Fri Sep 17 18:53:33 +0000 2010
//             [favourites_count] => 85
//             [utc_offset] => 7200
//             [time_zone] => Amsterdam
//             [geo_enabled] => 1
//             [verified] => 
//             [statuses_count] => 807
//             [lang] => en
//             [contributors_enabled] => 
//             [is_translator] => 
//             [is_translation_enabled] => 
//             [profile_background_color] => 9AE4E8
//             [profile_background_image_url] => http://abs.twimg.com/images/themes/theme16/bg.gif
//             [profile_background_image_url_https] => https://abs.twimg.com/images/themes/theme16/bg.gif
//             [profile_background_tile] => 
//             [profile_image_url] => http://pbs.twimg.com/profile_images/1192600164/d843c2d6s8989734_normal.jpg
//             [profile_image_url_https] => https://pbs.twimg.com/profile_images/1192600164/d843c2d6s8989734_normal.jpg
//             [profile_banner_url] => https://pbs.twimg.com/profile_banners/191932900/1394296002
//             [profile_link_color] => 0084B4
//             [profile_sidebar_border_color] => BDDCAD
//             [profile_sidebar_fill_color] => DDFFCC
//             [profile_text_color] => 333333
//             [profile_use_background_image] => 1
//             [default_profile] => 
//             [default_profile_image] => 
//             [following] => 
//             [follow_request_sent] => 
//             [notifications] => 
//         )

//     [geo] => 
//     [coordinates] => 
//     [place] => 
//     [contributors] => 
//     [retweet_count] => 0
//     [favorite_count] => 0
//     [entities] => Array
//         (
//             [hashtags] => Array
//                 (
//                 )

//             [symbols] => Array
//                 (
//                 )

//             [urls] => Array
//                 (
//                 )

//             [user_mentions] => Array
//                 (
//                     [0] => Array
//                         (
//                             [screen_name] => OwenTrefonwys
//                             [name] => Owen Roberts
//                             [id] => 243555574
//                             [id_str] => 243555574
//                             [indices] => Array
//                                 (
//                                     [0] => 0
//                                     [1] => 14
//                                 )

//                         )

//                     [1] => Array
//                         (
//                             [screen_name] => mikefclarke
//                             [name] => Michael Clarke
//                             [id] => 599441465
//                             [id_str] => 599441465
//                             [indices] => Array
//                                 (
//                                     [0] => 15
//                                     [1] => 27
//                                 )

//                         )

//                 )

//         )

//     [favorited] => 
//     [retweeted] => 
//     [lang] => en
// )
// 1