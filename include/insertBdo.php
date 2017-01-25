<?php

function addInfo($requet,$info,$debug=null){
	$sql= new SQLpdo();
	$idGen=$sql->insert($requet,$info,$debug);
	return $idGen;

}

function allInfo(){

	$sql= new SQLpdo();
	$tab=$sql->fetchAll("SELECT * FROM `TABLE 34`");
	foreach ($tab as $key => $value) {
		# code...

		 $id_realisateur= verifInfo("SELECT * FROM `ltp_realisateur` WHERE `realisateur`=:info",$value["realisateur"]);
		 /*echo "id_realisateur => ".strval($id_realisateur);*/
		 /*print_r($id_realisateur);*/
		/*print_r($value);*/
		if ($id_realisateur==null){
			$id_realisateur=addInfo("INSERT INTO `ltp_realisateur` (realisateur) VALUES ( :info );", array(':info' => $value["realisateur"]));
		}else{
			majInfo("UPDATE `TABLE 34` SET `id_realisateur` = :id_realisateur WHERE `TABLE 34`.`id` = :id",array(':id' => $value["id"], ":id_realisateur"=>$id_realisateur['id']));
		}
		/*echo "id_realisateur => ".strval($id_realisateur);*/
		/* print_r($id_realisateur);
		echo "</br>";*/


		/*arrondissement*/

		$id_arrondissement= verifInfo("SELECT * FROM `ltp_arrondissement` WHERE `arrondissement`=:info",strval($value["arrondissement"]));
		/*echo "id_arrondissement => ".strval($id_arrondissement);*/
		
		
		if ($id_arrondissement==null){
			$id_arrondissement=addInfo("INSERT INTO `ltp_arrondissement` (arrondissement) VALUES ( :info );",array(':info' => $value["arrondissement"]));
		}else{
			majInfo("UPDATE `TABLE 34` SET `id_arrondissement` = :id_arrondissement WHERE `TABLE 34`.`id` = :id",array(':id' => $value["id"], ":id_arrondissement"=>$id_arrondissement['id']));
		}
		
		echo "</br>";

		/*titre*/

		 $id_titre_film= verifInfo("SELECT * FROM `ltp_film` WHERE `titre`=:info",$value["titre"]);
		 
		
		if ($id_titre_film==null){
			$id_titre_film=addInfo("INSERT INTO `ltp_film` (titre) VALUES ( :info );",array(':info' => $value["titre"]));
		}else{
			majInfo("UPDATE `TABLE 34` SET `id_titre_film` = :id_titre_film WHERE `TABLE 34`.`id` = :id",array(':id' => $value["id"], ":id_titre_film"=>$id_titre_film['id']));
		}
		
		echo "</br>";
		$date_fin_evenement = $value["date_fin_evenement"];
		$date_fin_evenement = date("Y-m-d", strtotime($date_fin_evenement));
		$date_debut_evenement = $value["date_debut_evenement"];
		$date_debut_evenement = date("Y-m-d", strtotime($date_debut_evenement));
		print_r($date_debut_evenement);
		echo "</br>";
		print_r(addInfo("INSERT INTO `ltp_lieu` ( 
			date_debut_evenement, 
			date_fin_evenement, 
			cadre, 
			lieu, 
			adresse, 
			adresse_complete, 
			geo_coordinates, 
			id_arrondissement, 
			id_realisateur, 
			id_film) 
			VALUES (
			:date_debut_evenement, 
			:date_fin_evenement, 
			:cadre, 
			:lieu, 
			:adresse, 
			:adresse_complete, 
			:geo_coordinates, 
			:id_arrondissement, 
			:id_realisateur, 
			:id_film);", 
			array(
			":date_debut_evenement"=>$date_debut_evenement, 
			":date_fin_evenement"=>$date_fin_evenement, 
			":cadre"=>$value["cadre"],
			":lieu"=>$value["lieu"], 
			":adresse"=>$value["adresse"], 
			":adresse_complete"=>$value["adresse_complete"],
			":geo_coordinates"=>$value["geo_coordinates"], 
			":id_arrondissement"=> $id_arrondissement['id'], 
			":id_realisateur"=>$id_realisateur['id'], 
			":id_film"=>$id_titre_film['id'] ),"insert"));


		


	}
}

function verifInfo($requette,$info){
	$sql = new SQLpdo();
	$id = $sql->fetch($requette, array(':info' =>$info ));
	return $id;
}

function majInfo($requette,$id){
	$sql= new SQLpdo();
	$id = $sql->insert($requette, $id );
	return $id;
}



function test(){
	$allLieu = new realisateur();
	
	$lieu = new lieu();
	$nbLieu = $lieu->getByFilmId(10);
	$nbFilm = $allLieu->countFilm($tablieu[5]['id']);
	print_r($nbLieu);
}


function returnDataGeo(){

	$sql = new SQLpdo();
	$tabData = $sql->fetchAll("SELECT * FROM `ltp_lieu` WHERE `geo_coordinates`='' " );
	

	return $tabData;

}

function addCoordonne($id,$coordonne){


	$sql= new SQLpdo();
	$tabData=$sql->insert("UPDATE `ltp_lieu` SET `geo_coordinates` = :coordonne WHERE `ltp_lieu`.`id` = :id;", array(":id"=>$id,":coordonne"=>$coordonne) );
	
	return $tabData;

}



/**
 * Fonction de récupération de géopoint google maps
 */
function get_coords($address){
  // je construit une URL avec l'adresse
	$coords=array();
	$base_url="http://maps.googleapis.com/maps/api/geocode/xml?";
	// ajouter &region=FR si ambiguité (lieu de la requete pris par défaut)
	$request_url = $base_url . "address=" . urlencode($address).'&sensor=false';
	$xml = simplexml_load_file($request_url) or die("url not loading");
	//print_r($xml);
	$coords['lat']=$coords['lon']='';
	$coords['status'] = $xml->status ;
	if($coords['status']=='OK')
	{
	 $coords['lat'] = $xml->result->geometry->location->lat ;
	 $coords['lon'] = $xml->result->geometry->location->lng ;
	}
	return $coords;
}

function majCoordonne(){

	$donne= returnDataGeo();



    for ($i=0; $i <count($donne) ; $i++) { 
        # code...
        if ($donne[$i]['id']!=1602 and $donne[$i]['id']!=7393 and $donne[$i]['id']!=7481 and $donne[$i]['id']!=7836 and $donne[$i]['id']!=7932){
        	print_r($donne[$i]['id']);
        $champ=$donne[$i]['adresse_complete'];
        $info=get_coords($champ);
        // print_r($info['lon']);
        $adresse=$info['lat'].", ".$info['lon'];
        print_r($adresse);
        print_r($donne[$i]['id']);
        
         addCoordonne($donne[$i]['id'],$adresse);
        }
    	


        

    }
}