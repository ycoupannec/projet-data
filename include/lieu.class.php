<?php
class lieu{
	private $sql;
	function __construct(){
		$this->sql = new SQLpdo();
	}

	function getById($id) {

        // récupèreration dans la base de données = on obtient un Array
        $data = $this->sql->fetch("SELECT * FROM `ltp_lieu` WHERE id=:id AND `geo_coordinates`<>',' ", 
            array( 
                ':id' => $id 
                ));

        return $data;
    }
    function countLieux($id){
    	$data = $this->sql->fetch("SELECT COUNT(id) FROM `ltp_lieu` WHERE `id_film`=:id_film AND `geo_coordinates`<>','", 
            array(
                ':id_film' => $id 
                ));

        return $data;
    }
    function getByRealisateurId($id){
    	$data = $this->sql->fetchAll("SELECT * FROM `ltp_lieu` WHERE `id_realisateur`=:id_realisateur AND `geo_coordinates`<>','", 
            array(
                ':id_realisateur' => $id
                 ));

        return $data;
    }
    function getByFilmId($id){
    	$data = $this->sql->fetchAll("SELECT * FROM `ltp_lieu` WHERE `id_film`=:id_film AND `geo_coordinates`<>','", 
            array(
                ':id_film' => $id 
                ));

        return $data;
    }
    function findLieu($nb=null, $orderBy=null){
        $rqt = "SELECT * FROM `ltp_lieu` WHERE `geo_coordinates`<>',' ";
    	if ($orderBy!=null){
            $rqt .= " ORDER BY `date_debut_evenement` ".$orderBy." ";
        }
        if ($nb>0){
            $rqt .= " LIMIT 0,".$nb." ";
        }

        

        $data = $this->sql->fetchAll($rqt);
		return $data;
    }
    function getArrondissement($id){
		$arrondissement = new arrondissement();
		$data = $arrondissement->getArrondissement($id);
		return $data;
	}
}