<?php
class realisateur{
	private $sql;
	function __construct(){
		$this->sql= new SQLpdo();
	}

    // récupèrer le realisateur à partir de son ID
    // @param $id est un entier qui correspond à l'id de réalisateur
	function getById($id) {

        // récupèreration dans la base de données = on obtient un Array
        $data = $this->sql->fetch("SELECT * FROM `ltp_realisateur` WHERE `id`=:id", array(':id' =>$id ));

        return $data;
    }

    // renvoie le nombre de film réaliser par le réalisateur
    // @param $id est un entier qui correspond à l'id de réalisateur
    function countFilm($id){
    	$data = $this->sql->fetch("SELECT COUNT(`ltp_film`.id) FROM `ltp_film`,`ltp_lieu` WHERE `ltp_film`.id=`ltp_lieu`.id_film and `ltp_lieu`.`id_realisateur`=:id_realisateur", array(':id_realisateur' =>$id ));

        return $data;
    }

    // renvoie le nombre de lieu ou le réalisateur à tourner un film
    // @param $id est un entier qui correspond à l'id de réalisateur
    function countLieu($id){
        $data = $this->sql->fetch("SELECT COUNT(id_lieu) FROM `ltp_lieu` WHERE `id_realisateur`=:id_realisateur", array(':id_realisateur' =>$id ));

        return $data;
    }
    
    // renvoie tout les réalisateur

    function findRealisateur(){
        $data = $this->sql->fetchAll("SELECT * FROM `ltp_realisateur` ");
        $data = $this->getUrl($data);
		return $data;
    }

    // renvoie le nombre de réalisateur
    function countRealisateur(){
    	$data = $this->sql->fetch("SELECT COUNT(id) FROM `ltp_realisateur` ");

        return $data;
    }

    // renvoie les informations du réalisateur à partir de l'id du film
    // $id correspond à l'id du film
    function getByFilmId($id){
    	$data = $this->sql->fetch("SELECT `ltp_realisateur`.* FROM `ltp_realisateur`, `ltp_lieu` WHERE `ltp_realisateur`.id=`ltp_lieu`.id_realisateur and `ltp_lieu`.id_film= :id ", array(":id" => $id));

        return $data;
    }

    // renvoie les informations du réalisateur à partir de l'id du lieu
    // $id correspond à l'id du lieu
    function getByLieuId($id){
    	$data = $this->sql->fetchAll("SELECT `ltp_realisateur`.* FROM `ltp_realisateur`, `ltp_lieu` WHERE `ltp_realisateur`.id=`ltp_lieu`.id_realisateur and `ltp_lieu`.id= :id ", array(":id" => $id));

        return $data;
    }

    // renvoie les informations des films à partir de l'id du realisateur
    // $id correspond à l'id du realisateur
    function getFilmByIdRealisateur($id){
    	$data = $this->sql->fetchAll("SELECT DISTINCT `ltp_film`.* FROM `ltp_realisateur` , `ltp_film` , `ltp_lieu` WHERE `ltp_film`.id=`ltp_lieu`.id_film and `ltp_realisateur`.id=`ltp_lieu`.id_realisateur and `ltp_realisateur`.id= :id ", array(":id" => $id));

        return $data;
    }

    // renvoie les url pour l'affichage des films par réalisateur 
    // $data correspond au tableau de films du realisateur
    function getUrl($data){
        for ($i = 0; $i < count($data); $i++) { 
         # code...
        // à ajouter à la class realisateur : get url
            $data[$i]['URL'] = URL_SITE.'index.php?action=viewByRealisateurId&idRealisateur='.$data[$i]['id'];
        }
        return $data;
    }
    

}