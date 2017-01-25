<?php
class arrondissement{

	private $sql;

	function __construct(){
		$this->sql= new SQLpdo();
	}

	function getArrondissement($id){
		$data = $this->sql->fetchAll("SELECT * FROM `ltp_arrondissement` WHERE id=:id",array(":id"=>$id));
		return $data;
	}

	function countArrondissement(){
		$data = $this->sql->fetch("SELECT count(id) FROM `ltp_arrondissement` ");
		return $data;
	}

	function getByFilmId($id){
		$data = $this->sql->fetchAll("SELECT `ltp_arrondissement`.* FROM `ltp_arrondissement`, `ltp_lieu` WHERE `ltp_arrondissement`.id=`ltp_lieu`.id_arrondissement and `ltp_lieu`.id_film=:id_film ", array(":id_film"=>$id));
		return $data;
	}

	function findArrondissement($nb=0){
		$data = $this->sql->fetchAll("SELECT `ltp_arrondissement`.* FROM `ltp_arrondissement`");
		return $data;
	}

	function getLieuByArrondissement($id){
		$data = $this->sql->fetchAll("SELECT `ltp_lieu`.* FROM `ltp_lieu`.id_arrondissement=`ltp_arrondissement`.id and `ltp_arrondissement`.id=:id", array(':id'=>$id));
		return $data;
	}
}
