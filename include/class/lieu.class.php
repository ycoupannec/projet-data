<?php
class lieu{
	private $sql;
	function __construct(){
		$this->sql = new SQLpdo();
	}

    // renvoie les informations du lieu à partir de son id
    // $id correspond à l'id du lieu
	function getById($id) {

        // récupèreration dans la base de données = on obtient un Array
        $data = $this->sql->fetch("SELECT * FROM `ltp_lieu` WHERE id=:id AND (`geo_coordinates`<>',' OR `geo_coordinates`<>'') ", 
            array( 
                ':id' => $id 
                ));
        $data['date_debut_evenement'] = $this->dateFrFormat($data['date_debut_evenement']);

        return $data;
    }

    // renvoie le nombre de lieu total
    function countLieux($id){
    	$data = $this->sql->fetch("SELECT COUNT(id) FROM `ltp_lieu` WHERE `id_film`=:id_film AND (`geo_coordinates`<>',' AND `geo_coordinates`<>'')", 
            array(
                ':id_film' => $id 
                ));

        return $data;
    }

    // renvoie les informations du lieu à partir de l'id du realisateur
    // $id correspond à l'id du realisateur
    function getByRealisateurId($id){
    	$data = $this->sql->fetchAll("SELECT * FROM `ltp_lieu` WHERE `id_realisateur`=:id_realisateur AND (`geo_coordinates`<>',' AND `geo_coordinates`<>'')", 
            array(
                ':id_realisateur' => $id
                 ));

        return $data;
    }

    // renvoie les informations du lieu à partir de l'id du film
    // $id correspond à l'id du film
    function getByFilmId($id){
    	$data = $this->sql->fetchAll("SELECT * FROM `ltp_lieu` WHERE `id_film`=:id_film AND (`geo_coordinates`<>',' AND `geo_coordinates`<>'')", 
            array(
                ':id_film' => $id 
                ));
        foreach ($data as $key => $value) {
            # code...
            $data[$key]['date_debut_evenement'] = $this->dateFrFormat($value['date_debut_evenement']);
            $data[$key]['date_fin_evenement'] = $this->dateFrFormat($value['date_fin_evenement']);

        }
       

        return $data;
    }

    // renvoie les informations de tout les lieux
    // $nb correspond à la limit d'affichage exemple les 5 premiers
    // $orderBy correspond à l'ordre d'affichage : croissant, décroissant
    function findLieu($nb=null, $orderBy=null){
        $rqt = "SELECT * FROM `ltp_lieu` WHERE (`geo_coordinates`<>',' AND `geo_coordinates`<>'') ";
    	if ($orderBy!=null){
            $rqt .= " ORDER BY `date_debut_evenement` ".$orderBy." ";
        }
        if ($nb>0){
            $rqt .= " LIMIT 0,".$nb." ";
        }

        $data = $this->sql->fetchAll($rqt);
        foreach ($data as $key => $value) {
            # code...
            $data[$key]['date_debut_evenement'] = $this->dateFrFormat($value['date_debut_evenement']);
            $data[$key]['date_fin_evenement'] = $this->dateFrFormat($value['date_fin_evenement']);

        }
		return $data;
    }

     // renvoie les informations de l'arrondissement à partir de l'id de l'arrondissement
    // $id correspond à l'id de l'arrondissement.
    function getArrondissement($id){
		$arrondissement = new arrondissement();
		$data = $arrondissement->getArrondissement($id);
		return $data;
	}

    function dateFrFormat($date){

        $date = new DateTime($date);
        return $date->format('d/m/Y');

    }
}