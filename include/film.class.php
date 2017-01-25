<?php
class film {
	private $sql;
	function __construct(){
		$this->sql= new SQLpdo();
	}
    // récupérer un film à partir de son identifiant
    // @param $id integer Code du film
    function getById($id) {

        // récupèreration dans la base de données = on obtient un Array
        
		$data = $this->sql->fetch("SELECT * FROM `ltp_film` WHERE id=:id", array(':id' =>$id));
         $data['lieux'] = $this->getLieux($id);
         $realisateur= $this->getRealisateur($id);
         $data['realisateur'] =$realisateur["realisateur"];
         $data['arrondissement'] = $this->getArrondissement($id);
         $data['poster'] = $this->getPoster($data['titre']);
         $data['overview'] = $this->getOverview($data['titre']);
         print_r($data);
        
        return $data;
    }

    // récupèrer les lieux d'un film
    // @param $id integer Code du film
    function getLieux($id) {
        $lieu = new lieu();
        return $lieu->getByFilmId($id);
    }
    function getRealisateur($id) {
        $realisateur = new realisateur();
        return $realisateur->getByFilmId($id);
    }
    function getArrondissement($id) {
        $arrondissement = new arrondissement();
        return $arrondissement->getByFilmId($id);
    }

    // compter le nb de lieux pour un film
    // @param $id integer Code du film
    function countLieux($id) {
    	$lieu = new Lieu();
        return $lieu->countLieux($id);
     }

    // récupèrer une liste de films à partir d'un titre
    // @param $titre string Titre du film
    function findByTitre($titre) {
    	$data = $this->sql->fetch("SELECT * FROM `ltp_film` WHERE titre=:titre", array(':titre' =>$titre ));
		return $data;
    }
    function allFilm(){
    	$data = $this->sql->fetchAll("SELECT * FROM `ltp_film` ");
		return $data;
    }
    function getOverview($titre){
        $movie = new movieAPI($titre);
        return  $movie->getOverview();
    }
    function getPoster($titre){
        $movie = new movieAPI($titre);
        return $movie->getPoster();
    }

}


/**
* 
*/
class movieAPI
{
    private $movie;
    private $tmdb;
    private $movies;

    function __construct($titre)
    {
        $keyCache = md5($titre);
        
         if (file_exists('cache/'.$keyCache.'.txt')){
            $this->movie = unserialize(file_get_contents('cache/'.$keyCache.'.txt'));
         }else
         {
            $this->tmdb = new TMDB();
            $this->tmdb->setAPIKey(APIKEY);
            $this->movies = $this->tmdb->searchMovie($titre);
            $this->movie = $this->tmdb->getMovie($this->getID());    
            //file_put_contents('cache/'.$keyCache.'.txt',serialize($this->movie));
        }

        
         print_r($this->movie);

    }
    function getID(){
        return $this->movies[0]->getID();
        // return 11;
    }
    function getReviews(){
        return $this->movie->getReviews();
    }
    function getGenres(){
        return $this->movie->getGenres();
    }
    function getTrailer(){
        return $this->movie->getTrailer();
    }
    function getTrailers(){
        
        $test = $this->movie->getTrailers();
        return $test;

    }
    function getPoster(){
        $picture = "http://image.tmdb.org/t/p/original/". $this->movie->getPoster();
        return $picture;
    }
    function getTagline(){
        return $this->movie->getTagline();
    }
    function getOverview(){
        return $this->movie->getOverview();
    }
}



