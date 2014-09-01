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
		// Log::info('Called');

		// Log::info($file);
		// A list of permitted file extensions
		$allowed = array('png', 'jpg', 'gif','zip');

		if(isset($file['upl']) && $file['upl']['error'] == 0){

			// Log::info('if one');

		    $extension = pathinfo($file['upl']['name'], PATHINFO_EXTENSION);

		    if(!in_array(strtolower($extension), $allowed)){
		        echo '{"status":"error"}';
		        exit;
		    }

		    // Log::info('before rename');
			$newFilename = self::generateRandomString() . '.' . $extension;

			// Log::info('Extension ' . $extension);

		    if(move_uploaded_file($file['upl']['tmp_name'], '/var/www/app/storage/photos/'.$newFilename)){

		        echo '{"status":"success"}';
		        // $exif = exif_read_data('/var/www/app/storage/photos/'.$newFilename);
		        // Log::info($exif);


				$exif = exif_read_data('/var/www/app/storage/photos/'.$newFilename);
				$lon = self::getGps($exif["GPSLongitude"], $exif['GPSLongitudeRef']);
				$lat = self::getGps($exif["GPSLatitude"], $exif['GPSLatitudeRef']);
				Log::info($lat . '  ' . $lon);

		        exit;
		    }
		}

		// Log::info('something is wrong');

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


}
