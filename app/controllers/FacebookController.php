<?php

class FacebookController extends \BaseController {

	private $session;
	private $fbPhotos;

	public function __construct()
	{
		$this->fbPhotos = array();
	}

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

		if(count($result['data']) == 0) {
			$res['next'] = '';
			return json_encode($res);
		}
		
		$next = $result['paging']['cursors']['after'];

		$res = self::getAlbumCover($result['data'][0]['id']);

		$res['next'] = $next;

		return json_encode($res);

	}

	public function getAlbumCover( $id )
	{
		$fb = OAuth::consumer( 'Facebook' );
		$arr = array();

		try{
			$result = json_decode( $fb->request( "/$id/photos?limit=1" ) , true );	

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

	public function album( $id ) 
	{

		$photos = self::getAlbumPhotos($id);

		//echo '<pre>' , print_r($this->fbPhotos) , '</pre>';

    	$data['title'] = 'Upload';
		$data['template'] = 'upload/facebook_album';

		$data['images'] = $this->fbPhotos;

		return View::make('includes/main', array( 'data' => $data) );	
	}

	public function getAlbumPhotos($id , $after='')
	{
		$fb = OAuth::consumer( 'Facebook' );

		if($after != '') {
			$afterQuery = '?after='.$after;
		}else{
			$afterQuery = '';
		}

		$result = json_decode( $fb->request( "/$id/photos" . $afterQuery) , true );	

		$arr = array();

		foreach($result['data'] as $res) {

			$data['id'] = $res['id'];
			$data['image'] = $res['images'][1]['source'];
			$data['created_time'] = $res['created_time'];
			if(isset($res['place'])) {
				$data['location'] = $res['place']['name'];
				$data['latitude'] = $res['place']['location']['latitude'];
				$data['longitude'] = $res['place']['location']['longitude'];				
			}


			array_push($this->fbPhotos, $data);

		}
		if( isset($result['paging']['cursors']['after'])) {
			self::getAlbumPhotos($id , $result['paging']['cursors']['after']);
		}
		// if(array_key_exists($result['paging']['cursors']['after'])) {
		// 	self::getAlbumPhotos($id , $result['paging']['cursors']['after']);
		// }

		//echo '<pre>' , print_r($result) ,'</pre>';
		
	}

	public function twitter()
	{    
		// get twitter service
	    $tw = OAuth::consumer( 'Twitter' );
	    $result = json_decode( $tw->request( 'statuses/user_timeline.json?since=2013-01-12&until=2013-07-12' ), true );

	    // statuses/user_timeline.json?
	    // include_entities=true&
	    // inc‌​lude_rts=true&
	    // screen_name={screen_name}&
	    // since:2011-05-16&
	    // until:2011-08-16

	    foreach($result as $res) 
	    {
	    	echo '<pre>' , print_r($res['text']) ,'</pre>';
	    } 
	    


	}

}
