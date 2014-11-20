<?php

use Jenssegers\Mongodb\Model as Eloquent;

class Dbpedia extends Eloquent {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $collection = 'locations';
    protected $connection = 'mongodb';

    protected static $dbpedia = 'http://lookup.dbpedia.org/api/search.asmx/KeywordSearch?QueryClass=place&QueryString=';   

    public static function get_data($url) 
    {
        $ch = curl_init();
        $timeout = 5;
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
    }

    public static function getDbpediaInformation( $city , $storyId )
    {
        Log::info('trying to get dbpedia');
    	if(isset($city['locality'])) {
    		$cityName = $city['locality'];


            $cityResults = self::checkSavedDbpediaEntry( $cityName );

            // Check to see if the city name has already been saved
            if( $cityResults != false) {
                // Log::info('There is an entry');
                // Log::info('Result of city ' . $cityResults);
                // Log::info('Story id ' . $storyId);
                $updateStory = DBLayer::saveDbpedia( $storyId , $cityResults );
                return;
            }
            else{
                // Log::info('No entry found');

                $dbpediaUrl = self::$dbpedia.$cityName;

                // Log::info('City ' . $cityName);

                $data = self::get_data($dbpediaUrl);

                $rdf = simplexml_load_string($data);

                $rdfURI = $rdf->Result->URI;

                $result = self::transformRDF($rdfURI);

                // Log::info($result);

                $cityId = self::addNewCity( $cityName , $result );

                $updateStory = DBLayer::saveDbpedia( $storyId , $cityId );

                Log::info('cityInfo '. $storyId . ' ' . $cityId);

                return;
            }
    	}
    }

    public static function transformRDF( $rdfURI )
    {
		$context = stream_context_create(array('http' => array(
	      'header' => 'Accept: application/rdf+xml, text/rdf+xml, text/xml;q=0.1, application/xml;q=0.1, text/plain;q=0.1',
	  	)));

	  	$uriResult = file_get_contents($rdfURI , false , $context);

	    $cityInfo = new SimpleXMLElement($uriResult);

	    $xsl = new DOMDocument;
	    $xsl->load('/var/www/public/xslt/rdf.xsl');

	    // Configure the transformer
	    $proc = new XSLTProcessor;
	    $proc->importStyleSheet($xsl); // attach the xsl rules

	    $city = $proc->transformToXML($cityInfo);

	    return $city;
    }

    /**
     * 
     * @param $cityName string
     * @return boolean
     */
    private static function checkSavedDbpediaEntry( $cityName )
    {
        // Log::info('Looking for ' . $cityName);
        $location = Dbpedia::where('cityName', '=', $cityName)->first();
        // Log::info($location);
        if(count($location) > 0){
            Log::info('found ' . $location['id']);
            return $location['id'];
        }else{
            Log::info('We have no results for this query');
            return false;
        }
    }

    private static function addNewCity( $cityName , $result )
    {
        $city = new Dbpedia;

        $cityInfo = simplexml_load_string($result);

        $cityDescription = (string) $cityInfo->description;
        $longitude = (string) $cityInfo->longitude;
        $latitude = (string) $cityInfo->latitude;

        $loc = array( $longitude , $latitude);

        $city->cityName = $cityName;
        $city->description = $cityDescription;
        $city->loc = $loc;

        $city->save();

        $id = $city->id;

        return $id;
    }

    public static function getCity( $id )
    {
        $city = Dbpedia::where('_id' , '=' , $id);
        return $city;
    }

    public static function getCityDetails( $id )
    {
        $city = Dbpedia::where('_id' , '=' , $id)->first();
        return $city;
    }

}
