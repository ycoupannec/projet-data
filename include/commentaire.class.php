<?php
class commentaire{

	private $sql;

	function __construct(){
		$this->sql= new SQLpdo();
	}

	

	function getcommentaire($id){
		$data = $this->sql->fetchAll("SELECT * FROM `ltp_commentaires` WHERE id=:id",array(":id"=>$id));
		return $data;
	}

	function countCommentaire(){
		$data = $this->sql->fetch("SELECT count(id) FROM `ltp_commentaires` ");
		return $data;
	}


	function findCommentaire($nb=0){
		$data = $this->sql->fetchAll("SELECT `ltp_commentaires`.* FROM `ltp_commentaires`");
		return $data;
	}

	function getLieuByCommentaire($id){
		$data = $this->sql->fetchAll("SELECT `ltp_lieu`.* FROM `ltp_lieu`, `ltp_commentaires` WHERE`ltp_commentaires`.id_lieu=`ltp_lieu`.id and `ltp_commentaires`.id=:id", array(':id'=>$id));
		return $data;
	}

	function countCommentaireByLieu($id){
		$data = $this->sql->fetch("SELECT count(id) FROM `ltp_commentaires`, `id_lieu` WHERE `ltp_commentaires`.id_lieu=`id_lieu`.id and `id_lieu`.id=:id",array(":id"=>$id));
		return $data;
	}

	function getCommentaireByLieu($id,$orderBy=null){
		$rqt="SELECT `ltp_commentaires`.* FROM `ltp_commentaires`, `id_lieu` WHERE `ltp_commentaires`.id_lieu=`id_lieu`.id and `id_lieu`.id=:id";

		if ($orderBy!=null){
			$rqt .= " ORDER BY date ".$orderBy;
		}
		$data = $this->sql->fetchAll($rqt,array(":id"=>$id));
		return $data;
	}


	function setCommentaire($idLieu,$date,$commentaire){
		$data = $this->sql->insert("INSERT INTO `ltp_commentaires` ( `commentaire`, `date`, `id_lieu`) VALUES ( ':commentaire', ':date', ':idLieu');",array(":idLieu"=>$idLieu,":date"=>$date, ":commentaire"=>$commentaire));
		return $data;
	}
}
