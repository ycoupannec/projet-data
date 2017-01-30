<?php
$lastId=null;
if((request('idLieu')&&request('commentaire'))!=false){

	$idLieu=request('idLieu');
	$comm=request('commentaire');
	$commentaire=new commentaire();
	$date=date('Y-m-d H:i:s');
	$lastId=$commentaire->setCommentaire($idLieu,$date,$comm);
	
}
return $lastId;