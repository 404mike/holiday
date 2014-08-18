<?php

class FacebookController extends \BaseController {

	private $session;

	public function album()
	{
		$fb = OAuth::consumer( 'Facebook' );
		$result = json_decode( $fb->request( '/me/albums' ), true );

		foreach($result['data'] as $album) {
			self::getAlbumCover($album['id']);
		}
	}

	public function getAlbumCover( $id )
	{
		$fb = OAuth::consumer( 'Facebook' );

		try{
			$result = json_decode( $fb->request( "/$id/photos?limit=1" ) , true );	

			$images = $result['data'][0]['images'];

			if(count($images) <= 3) {
				$count = count($images);
				// echo '<pre>' , print_r($result['data'][0]['images'][$count]) , '</pre>';
				echo '<img src="'.$result['data'][0]['images'][$count]['source'].'" />';
			}else{
				// echo '<pre>' , print_r($result['data'][0]['images'][3]) , '</pre>';
				echo '<img src="'.$result['data'][0]['images'][3]['source'].'" />';
			}


		}catch (Exception $e){
		}
		
	}

}
