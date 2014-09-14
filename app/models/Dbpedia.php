<?php

class Dbpedia {

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

    public static function getDbpediaInformation( $city )
    {
    	if(isset($city['locality'])) {
    		$cityName = $city['locality'];
    	}
        $dbpediaUrl = self::$dbpedia.$cityName;

        // Log::info('URL ' . $dbpediaUrl);

        $data = self::get_data($dbpediaUrl);

        $rdf = simplexml_load_string($data);

		$rdfURI = $rdf->Result->URI;

		$result = self::transformRDF($rdfURI);

		return $result;
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

}
