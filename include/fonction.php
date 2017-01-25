<?php

function request($key){
	 /*&& !empty(trim($_REQUEST[$key]))*/
	if(isset($_REQUEST[$key])){
		return $_REQUEST[$key];
	}else{
		return false;
	}

}

function get_info_movie($titre){
  // je construit une URL avec l'adresse
	$infos=array();
	$base_url="http://maps.googleapis.com/maps/api/geocode/xml?";
	// ajouter &region=FR si ambiguité (lieu de la requete pris par défaut)
	$request_url = $base_url . "address=" . urlencode($address).'&sensor=false';
	$xml = simplexml_load_file($request_url) or die("url not loading");
	//print_r($xml);
	$infos['lat']=$infos['lon']='';
	$infos['status'] = $xml->status ;
	if($infos['status']=='OK')
	{
	 $infos['lat'] = $xml->result->geometry->location->lat ;
	 $infos['lon'] = $xml->result->geometry->location->lng ;
	}
	return $infos;
}

function testTMDB(){
	$apikey="83f0bbdeeb5edce1cd036b60128e5a25";
	$tmdb = new TMDB($apikey, 'en', true);
	$movies = $tmdb->searchMovie("underworld");

    echo '  <div class="panel panel-default">
                <div class="panel-body">
                    <ul>';

    foreach($movies as $movie){
        echo '          <li>'. $movie->getTitle() .' (<a href="https://www.themoviedb.org/movie/'. $movie->getID() .'">'. $movie->getID() .'</a>)</li>';
    }

    echo '          </ul>
                </div>
            </div>';
}