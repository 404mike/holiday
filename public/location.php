<?php

class Location {

    protected $openstreetmap = 'http://nominatim.openstreetmap.org/reverse?format=xml&';
    protected $dbpedia = 'http://lookup.dbpedia.org/api/search.asmx/KeywordSearch?QueryClass=place&QueryString=';

    public function __construct() 
    {
        $lat = 52.414723;
        $lon = -4.082681;
        $this->getOpenStreetMapLocation( $lat , $lon );
    }

    public function get_data($url) 
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

    private function getOpenStreetMapLocation( $lat , $lon )
    {
        $openstreetmapUrl = $this->openstreetmap.'lat='.$lat.'&lon='.$lon.'&zoom=18&addressdetails=1';
        echo $openstreetmapUrl;
        $openstreetmapData =  $this->get_data($openstreetmapUrl);

        $data = simplexml_load_string($openstreetmapData);
        $city = $data->addressparts->city->{0};
        $this->getDbpediaInformation( $city);   
    }

    private function getDbpediaInformation( $city )
    {
        $dbpediaUrl = $this->dbpedia.$city;

        $data = $this->get_data($dbpediaUrl);

        print_r($data);
    }

}

new Location();