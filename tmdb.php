<?php
require_once "include/fonction.php";
require_once "include/insertBdo.php";

require_once "include/.init.php";
require_once "include/film.class.php";
require_once "include/realisateur.class.php";
require_once "include/lieu.class.php";
require_once "include/arrondissement.class.php";
require_once "include/SQL.class.php";
require_once "include/tmdb_v3-PHP-API--master/tmdb-api.php";


$movie=new movieAPI("BUS PALLADIUM");
$getPoster=$movie->getPoster();
$getTagline=$movie->getTagline();
$getTrailers=$movie->getTrailers();

$getTrailer=$movie->getTrailer();
$getGenres=$movie->getGenres();
$getReviews=$movie->getReviews();
echo "<br/>getPoster :<br/>";
print_r($getPoster);
echo "<br/>getTagline :<br/>";
print_r($getTagline);
echo "<br/>getTrailers :<br/>";
print_r($getTrailers);
echo "<br/>getTrailer :<br/>";
print_r($getTrailer);
echo "<br/>getGenres :<br/>";
print_r($getGenres);
echo "<br/>getReviews :<br/>";
foreach ($getReviews as $key => $getReview) {
	print_r($getReview);
	# code...
}

$getOverview=$movie->getOverview();
echo "<br/>getOverview :<br/>";
print_r($getOverview);




// $tmdb = new TMDB();
// $tmdb->setAPIKey(APIKEY);
// $movie = $tmdb->searchMovie("cavalcade");
// echo $movie[0]->getTitle();