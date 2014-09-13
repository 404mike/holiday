<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class Upload extends Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	public static function uploadFile( $file )
	{
		// A list of permitted file extensions
		$allowed = array('png', 'jpg', 'gif','zip' ,'JPG');

		if(isset($file['upl']) && $file['upl']['error'] == 0){

		    $extension = pathinfo($file['upl']['name'], PATHINFO_EXTENSION);

		    if(!in_array(strtolower($extension), $allowed)){
		        echo '{"status":"error"}';
		        exit;
		    }

			$newFilename = self::generateRandomString() . '.' . $extension;


		    if(move_uploaded_file($file['upl']['tmp_name'], '/var/www/app/storage/photos/'.$newFilename)){

				$exif = @exif_read_data('/var/www/app/storage/photos/'.$newFilename);				

				if(isset($exif["DateTime"])) {
					$dateCreated = strtotime($exif["DateTimeOriginal"]);
				}else{
					$dateCreated = '1111111111';
				}


				if(isset($exif["GPSLongitude"])) {
					$lon = self::getGps($exif["GPSLongitude"], $exif['GPSLongitudeRef']);
					$lat = self::getGps($exif["GPSLatitude"], $exif['GPSLatitudeRef']);				
				}else{
					$lon = '';
					$lat = '';
				}

				echo 
				'{
					"filename":"'.$newFilename.'",
					"date":"'.$dateCreated.'",
					"lon":"'.$lon.'" ,
					"lat":"'.$lat.'"
				}';

				// Log::info($lat . '  ' . $lon);
				// Log::info('Date ' . $dateCreated);

		        exit;
		    }
		}

		// Log::info('something is wrong with ');

		echo '{"status":"error"}';
		exit;
	}

    public static function generateRandomString($length = 20) 
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $randomString;
    }  

	public static function getGps($exifCoord, $hemi) {

	    $degrees = count($exifCoord) > 0 ? self::gps2Num($exifCoord[0]) : 0;
	    $minutes = count($exifCoord) > 1 ? self::gps2Num($exifCoord[1]) : 0;
	    $seconds = count($exifCoord) > 2 ? self::gps2Num($exifCoord[2]) : 0;

	    $flip = ($hemi == 'W' or $hemi == 'S') ? -1 : 1;

	    return $flip * ($degrees + $minutes / 60 + $seconds / 3600);

	}

	public static function gps2Num($coordPart) {

	    $parts = explode('/', $coordPart);

	    if (count($parts) <= 0)
	        return 0;

	    if (count($parts) == 1)
	        return $parts[0];

	    return floatval($parts[0]) / floatval($parts[1]);
	}


	public static function getSinglelatLng( $data )
	{
		$arr = [];

		foreach($data['data'] as $d) {

			// Get facebook feed location
			if($d['type'] == 'facebookfeed') {
				// Check if the data has a place
				if(isset($d['place'])) {
					$lat = $d['place']['location']['latitude'];
					$lng = $d['place']['location']['longitude'];

					array_push($arr, $lat.','.$lng);
				}
			}

			// Get image location
			if($d['type'] == 'image') {
				if(isset($d['longitude'])) {
					$lat = $d['latitude'];
					$lng = $d['longitude'];		

					array_push($arr, $lat.','.$lng);		
				}
			}
		} // end foreach

		// array to keep rounded geo locations
		$locations = [];

		// Loop through $arr and round off the locations
		foreach($arr as $a) {
			$geo = explode(',', $a);
			// $lat = round($geo[0],1);
			// $lng = round($geo[1],1);
			$lat = substr($geo[0], 0, 4);
			// TODO check if this has a minus
			$lng = substr($geo[1], 0, 5);

			// Check if the location already exists and increment
			// else add it to the array
			if(array_key_exists($lat.','.$lng, $locations)){
				$locations[$lat.','.$lng] += 1;
			}else{
				$locations[$lat.','.$lng] = 1;
			}		
		}

		// Get geo location with most occurances
		$highestNum = max($locations);

		// Search the $locations array to see where the location appears
		$key = array_search($highestNum, $locations); 

		$keyLatLng = explode(',', $key);
		$lat = $keyLatLng[0];
		$lng = $keyLatLng[1];

		foreach($arr as $a) {

			if(preg_match('/'.$lat.'(.*),'.$lng.'(.*)/', $a)) {
				return $a;
			}
		}
	}

}
