<?php
class realisateur{
	private $sql;
	function __construct(){
		$this->sql= new SQLpdo();
	}

	function getById($id) {

        // récupèreration dans la base de données = on obtient un Array
        $data = $this->sql->fetch("SELECT * FROM `ltp_realisateur` WHERE `id`=:id", array(':id' =>$id ));

        return $data;
    }

    function countFilm($id){
    	$data = $this->sql->fetch("SELECT COUNT(`ltp_film`.id) FROM `ltp_film`,`ltp_lieu` WHERE `ltp_film`.id=`ltp_lieu`.id_film and `ltp_lieu`.`id_realisateur`=:id_realisateur", array(':id_realisateur' =>$id ));

        return $data;
    }

    function countLieu($id){
    	$data = $this->sql->fetch("SELECT COUNT(id_lieu) FROM `ltp_lieu` WHERE `id_realisateur`=:id_realisateur", array(':id_realisateur' =>$id ));

        return $data;
    }

    function findRealisateur(){
    	$data = $this->sql->fetchAll("SELECT * FROM `ltp_realisateur` ");
        $data = $this->getUrl($data);
		return $data;
    }

    function countRealisateur(){
    	$data = $this->sql->fetch("SELECT COUNT(id) FROM `ltp_realisateur` ");

        return $data;
    }

    function getByFilmId($id){
    	$data = $this->sql->fetch("SELECT `ltp_realisateur`.* FROM `ltp_realisateur`, `ltp_lieu` WHERE `ltp_realisateur`.id=`ltp_lieu`.id_realisateur and `ltp_lieu`.id_film= :id ", array(":id" => $id));

        return $data;
    }

    function getByLieuId($id){
    	$data = $this->sql->fetchAll("SELECT `ltp_realisateur`.* FROM `ltp_realisateur`, `ltp_lieu` WHERE `ltp_realisateur`.id=`ltp_lieu`.id_realisateur and `ltp_lieu`.id= :id ", array(":id" => $id));

        return $data;
    }

    function getFilmByIdRealisateur($id){
    	$data = $this->sql->fetchAll("SELECT DISTINCT `ltp_film`.* FROM `ltp_realisateur` , `ltp_film` , `ltp_lieu` WHERE `ltp_film`.id=`ltp_lieu`.id_film and `ltp_realisateur`.id=`ltp_lieu`.id_realisateur and `ltp_realisateur`.id= :id ", array(":id" => $id));

        return $data;
    }

    function getUrl($data){
        for ($i = 0; $i < count($data); $i++) { 
         # code...
        // à ajouter à la class realisateur : get url
            $data[$i]['URL'] = URL_SITE.'index.php?action=viewByRealisateurId&idRealisateur='.$data[$i]['id'];
        }
        return $data;
    }
    

}