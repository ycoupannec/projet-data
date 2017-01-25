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
         // print_r($data);
         // exit;
        
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
    	$data=$this->sql->fetch("SELECT * FROM `ltp_film` WHERE titre=:titre", array(':titre' =>$titre ));
		return $data;
    }
    function allFilm(){
    	$data=$this->sql->fetchAll("SELECT * FROM `ltp_film` ");
		return $data;
    }

}