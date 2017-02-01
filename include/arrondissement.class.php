<?php
class arrondissement{

	private $sql;

	function __construct(){
		$this->sql= new SQLpdo();
	}

	
	// renvoie les informations de l'arrondissement à partir de son id
    // $id correspond à l'id de l'arrondissement
	function getArrondissement($id){
		$data = $this->sql->fetchAll("SELECT * FROM `ltp_arrondissement` WHERE id=:id",array(":id"=>$id));
		return $data;
	}

	// renvoie le nombre d'arrondissement total dans la BDD
	function countArrondissement(){
		$data = $this->sql->fetch("SELECT count(id) FROM `ltp_arrondissement` ");
		return $data;
	}

	// renvoie les informations de l'arrondissement à partir de l'id du film
    // $id correspond à l'id du film
	function getByFilmId($id){
		$data = $this->sql->fetchAll("SELECT `ltp_arrondissement`.* FROM `ltp_arrondissement`, `ltp_lieu` WHERE `ltp_arrondissement`.id=`ltp_lieu`.id_arrondissement and `ltp_lieu`.id_film=:id_film ", array(":id_film"=>$id));
		return $data;
	}

	// renvoie tout les arrondissements.
	function findArrondissement($nb=0){
		$data = $this->sql->fetchAll("SELECT `ltp_arrondissement`.* FROM `ltp_arrondissement`");
		$data = $this->getUrl($data);
		return $data;
	}

	// renvoie les informations des lieux à partir de l'id de l'arrondissement
    // $id correspond à l'id de l'arrondissement
	function getLieuByArrondissement($id){
		$data = $this->sql->fetchAll("SELECT `ltp_lieu`.* FROM `ltp_lieu`, `ltp_arrondissement` WHERE`ltp_lieu`.id_arrondissement=`ltp_arrondissement`.id and `ltp_arrondissement`.id=:id", array(':id'=>$id));
		return $data;
	}

	// renvoie les informations des films à partir de l'id de l'arrondissement
    // $id correspond à l'id de l'arrondissement
	function getFilmByArrondissement($id){
		$data = $this->sql->fetchAll("SELECT DISTINCT `ltp_film`.* FROM `ltp_film`, `ltp_arrondissement`, `ltp_lieu`  WHERE  `ltp_lieu`.id_arrondissement=`ltp_arrondissement`.id and `ltp_lieu`.id_film=`ltp_film`.id and `ltp_arrondissement`.id=:id", array(':id'=>$id));
		return $data;
	}

	// renvoie les url pour l'affichage des films par arrondissement 
    // $data correspond au tableau de films de l'arrondissement
	function getUrl($data){
		for ($i = 0; $i < count($data); $i++) { 
         # code...
	        // à ajouter à la class film : get url
	        $data[$i]['URL'] = URL_SITE.'index.php?action=viewByArrondissementId&idArrondissement='.$data[$i]['id'];
	    }
	    return $data;
	}
}
