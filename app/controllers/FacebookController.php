<?php

class FacebookController extends \BaseController {

	private $session;
	private $fbPhotos;

	public function __construct()
	{
		$this->fbPhotos = array();
	}
	
	 /**
	   *
	   */
	public function main()
	{
    $data['title'] = 'Upload';
		$data['template'] = 'upload/facebook';
		return View::make('includes/main', array( 'data' => $data) );		
	}

	/**
	 *
	 */
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

	/**
	 *
	 */
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

	/**
     *
	 */
	public function album( $id ) 
	{
		$photos = self::getAlbumPhotos($id);

		//echo '<pre>' , print_r($this->fbPhotos) , '</pre>';

    	$data['title'] = 'Upload';
		$data['template'] = 'upload/facebook_album';

		$data['images'] = $this->fbPhotos;

		$start = $this->fbPhotos[0];
		$end = end($this->fbPhotos);

		$tweets = Twitter::main($start['created_time'] , $end['created_time']);

		echo '<pre>' , print_r($tweets) ,'</pre>';

		$feed = Facebook::feed($start['created_time'] , $end['created_time']);
		echo '<pre>' , print_r($feed) , '</pre>';

		echo '<pre>' , print_r($data['images']) , '</pre>';

		return View::make('includes/main', array( 'data' => $data) );	
	}

  /**
   *
   */
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
			$data['image'] = $res['images'][0]['source'];
			$data['created_time'] = strtotime($res['created_time']);
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
	}

}
