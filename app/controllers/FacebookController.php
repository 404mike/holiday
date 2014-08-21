<?php

class FacebookController extends \BaseController {

	private $session;

	public function main()
	{
    	$data['title'] = 'Upload';
		$data['template'] = 'upload/facebook';
		return View::make('includes/main', array( 'data' => $data) );		
	}

	public function nextAlbum( $after='' )
	{
		$fb = OAuth::consumer( 'Facebook' );

		if($after != '') {
			$afterQuery = '&after='.$after;
		}else{
			$afterQuery = '';
		}

		$result = json_decode( $fb->request( '/me/albums?limit=1' . $afterQuery ), true );

		//echo '<pre>' , print_r($result) ,'</pre>';

		if(count($result['data']) == 0) {
			$res['next'] = '';
			return json_encode($res);
		}
		
		$next = $result['paging']['cursors']['after'];


		$res = self::getAlbumCover($result['data'][0]['id']);
		// foreach($result['data'] as $album) {
		// 	$res = self::getAlbumCover($album['id']);
		// }

		$res['next'] = $next;

		//echo '<pre>' , print_r($res) ,'</pre>';

		//$data['album'] = json_encode($res);

		return json_encode($res);

	}

	public function getAlbumCover( $id )
	{
		$fb = OAuth::consumer( 'Facebook' );
		$arr = array();

		try{
			$result = json_decode( $fb->request( "/$id/photos?limit=1" ) , true );	

			//echo '<pre>' , print_r($result['data'][0]['images']) , '</pre>';

			$images = $result['data'][0]['images'][0];

			if(count($images) <= 3) {
				$count = count($images);
				$arr['id'] = $id;
				$arr['picture'] = $result['data'][0]['images'][0]['source'];
			}else{
				$arr['id'] = $id;
				$arr['picture'] = $result['data'][0]['images'][3]['source'];
			}

			return $arr;


		}catch (Exception $e){
		}
		
	}

}
