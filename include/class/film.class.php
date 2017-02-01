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
         $realisateur = $this->getRealisateur($id);
         $data['realisateur'] = $realisateur["realisateur"];
         $data['arrondissements'] = $this->getArrondissement($id);
         $data['commentaires'] = $this->getCommentaireByFilm($id);
         if (!empty($data['titre'])){
            $data['poster'] = $this->getPoster($data['titre']);   
            $data['overview'] = $this->getOverview($data['titre']);
         }

         
        return $data;
    }

    // récupèrer les lieux d'un film
    // @param $id integer Code du film
    function getLieux($id) {
        $lieu = new lieu();
        return $lieu->getByFilmId($id);
    }

    // récupèrer les realisateurs d'un film
    // @param $id integer Code du film
    function getRealisateur($id) {
        $realisateur = new realisateur();
        return $realisateur->getByFilmId($id);
    }

    // récupèrer les arrondissements d'un film
    // @param $id integer Code du film
    function getArrondissement($id) {
        $arrondissement = new arrondissement();
        return $arrondissement->getByFilmId($id);
    }

    // récupèrer les Commentaires d'un film
    // @param $id integer Code du film
    function getCommentaireByFilm($id){
        $commentaires = new commentaire();
        $lieux=$this->getLieux($id);
        $commentaire="";
        foreach ($lieux as $key => $lieu) {
            $commentaire[] = $commentaires->getCommentaireByLieu($lieu['id'],'desc');
        }
        
        return $commentaire;
    }

    // récupèrer les url pour chaque film
    // @param $data Tableau de film
    function getUrl($data){
        for ($i = 0; $i < count($data); $i++) { 
         # code...
        // à ajouter à la class film : get url
            $data[$i]['URL'] = URL_SITE.'index.php?action=viewByFilmId&id='.$data[$i]['id'];
        }
        return $data;
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

    // récupèrer tous les films
    function allFilm(){
    	$data = $this->sql->fetchAll("SELECT * FROM `ltp_film` ");
        $data = $this->getUrl($data);
		return $data;
    }

    // récupèrer les synopsis d'un film
    // @param $titre est le titre du film
    function getOverview($titre){
        $movie = new movieAPI($titre);
        if(!empty($movie)){
            return  $movie->getOverview();
        }
        return  $movie;
    }

     // récupèrer les affiches d'un film
    // @param $titre est le titre du film
    function getPoster($titre){
        $movie = new movieAPI($titre);
        if(!empty($movie)){
            return  $movie->getPoster();
        }
        return $movie;
    }

}


/**
* class pour l'api de TMDB qui cherche plus d'information sur les films
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
            if (!empty($this->movies)){
                $this->movie = $this->tmdb->getMovie($this->getID()); 
            }
               
            file_put_contents('cache/'.$keyCache.'.txt',serialize($this->movie));
        }


    }

    // retourne l'ID du film de TMDB
    function getID(){
        $data = $this->movies[0]->getID(); 
        return $data;
        
    }

    function getReviews(){
        $data = $this->movie->getReviews(); 
        return $data;
    }

    function getGenres(){
        $data = $this->movie->getGenres();
        return $data;
    }

    function getTrailer(){
        $data = $this->movie->getTrailer();
        return $data;
    }

    function getTrailers(){
        
        $data = $this->movie->getTrailers();
        return $data;

    }

    function getPoster($i = 3){
        
        $size[0] = 'w92';
        $size[1] = 'w154';
        $size[2] = 'w185';
        $size[3] = 'w342';
        $size[4] = 'w500';
        $size[5] = 'w780';
        $size[6] = 'original';
        
        $picture = "";
        if(!empty($this->movie)){
            $picture = "http://image.tmdb.org/t/p/".$size[$i]."//". $this->movie->getPoster();
        }
        return $picture;
    }

    function getTagline(){
        $Tagline = '';

        if(!empty($this->movie)){
            $Tagline = $this->movie->getTagline();
        }

        return $Tagline;
    }

    function getOverview(){
        $Overview = "";

        if(!empty($this->movie)){
            $Overview = $this->movie->getOverview();
        }

        return $Overview;
    }
}



