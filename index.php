
<?php
require_once "include/fonction.php";
require_once "include/insertBdo.php";
require_once "include/Mustache/Autoloader.php";
require_once "include/.init.php";
require_once "include/film.class.php";
require_once "include/realisateur.class.php";
require_once "include/lieu.class.php";
require_once "include/arrondissement.class.php";
require_once "include/SQL.class.php";
require_once "include/tmdb_v3-PHP-API--master/tmdb-api.php";
Mustache_Autoloader::register();


//on explique à Mustach qu'on va utiliser comme extension le .html
$options =  array('extension' => '.html');

$m = new Mustache_Engine(array(
    'loader' => new Mustache_Loader_FilesystemLoader('template', $options),
));

/*echo $m->render('header.inc');*/
// .inc.html

if (!request('action')){
    $film = new film();
    $allFilm = $film->allFilm();
    $realisateur=new realisateur();
    $allRealisateur = $realisateur->findRealisateur();
    $arrondissement=new arrondissement();
    $allArrondissement = $arrondissement->findArrondissement();


    for ($i=0; $i < count($allFilm); $i++) { 
         # code...
        // à ajouter à la class film : get url
        $allFilm[$i]['URL']=URL_SITE.'index.php?action=viewByFilmId&id='.$allFilm[$i]['id'];
    }
    for ($i=0; $i < count($allRealisateur); $i++) { 
         # code...
        // à ajouter à la class film : get url
        $allRealisateur[$i]['URL']=URL_SITE.'index.php?action=viewByRealisateurId&idRealisateur='.$allRealisateur[$i]['id'];
    }
    for ($i=0; $i < count($allArrondissement); $i++) { 
         # code...
        // à ajouter à la class film : get url
        $allArrondissement[$i]['URL']=URL_SITE.'index.php?action=viewByArrondissementId&idArrondissement='.$allArrondissement[$i]['id'];
    }
     // print_r(array('Film' => $allFilm));
    // print_r($film ->getLieux($allFilm['id']));
		$cssAccueil="<link rel='stylesheet' href='assets/css/style_accueil.css' />";

	 echo $m->render('header.inc', array('css'=>$cssAccueil));
     echo $m->render('index.inc',array('Film' => $allFilm, "URL"=>URL_SITE, 'FilmArrondissement' => $allArrondissement,'FilmRealisateur' => $allRealisateur ));

}else if(request('action')=="viewByFilmId"){

    $id=request('id');
    // $lieux=new lieu();
    // $tabLieux=$lieux->getByFilmId($id);

    $film=new film();
    $allFilm=$film->getById($id);
    /*print_r($allFilm);*/

    $listFilm=$film->allFilm();



    for ($i=0; $i < count($listFilm); $i++) {
         # code...
        $listFilm[$i]['URL']=URL_SITE.'index.php?action=viewByFilmId&id='.$listFilm[$i]['id'];

        $listFilm[$i]['active'] = false;
        if($listFilm[$i]['id'] == $id){
            $listFilm[$i]['active'] = true;
        }
    }
	$cssMap="<link rel='stylesheet' href='assets/css/stylemap.css' />";

 	echo $m->render('header.inc', array('css'=>$cssMap));
    echo $m->render('map.inc', array('Film' => $listFilm,"URL"=>URL_SITE."index.php?action=viewByFilmId&id="));
    echo $m->render('mapleaflet',$allFilm);
}else if(request('action')=='viewByArrondissementId'){
    $idArrondissement=request('idArrondissement');
    if (request('idFilm')==false){
        $arrondissements = new arrondissement();
        $filmArrondissement = $arrondissements->getFilmByArrondissement($idArrondissement);
        //print_r($arrondissement);
        
        $idFilm=$filmArrondissement[0]['id'];
        // print_r($idFilm);
        // exit;
    }else{
        $arrondissements = new arrondissement();
        $filmArrondissement = $arrondissements->getFilmByArrondissement($idArrondissement);
        $idFilm=request('idFilm');
    }
    // $lieux=new lieu();
    // $tabLieux=$lieux->getByFilmId($id);

    $film=new film();
    $allFilm=$film->getById($idFilm);
    /*print_r($allFilm);*/

     $listFilm=$filmArrondissement;
    /*print_r($allFilm);*/




    for ($i=0; $i < count($listFilm); $i++) {
         # code...
        $listFilm[$i]['URL']=URL_SITE.'index.php?action=viewByArrondissementId&idFilm='.$listFilm[$i]['id'].'&idArrondissement='.$idArrondissement;

        $listFilm[$i]['active'] = false;
        if($listFilm[$i]['id'] == $idFilm){
            $listFilm[$i]['active'] = true;
        }
    }
    $cssMap="<link rel='stylesheet' href='assets/css/stylemap.css' />";

    echo $m->render('header.inc', array('css'=>$cssMap));
    echo $m->render('map.inc', array('Film' => $listFilm,"URL"=>URL_SITE."index.php?action=viewByArrondissementId&idArrondissement=".$idArrondissement."&idFilm="));
    echo $m->render('mapleaflet',$allFilm);
}else if(request('action')=='viewByRealisateurId'){
    $idRealisateur=request('idRealisateur');
    if (request('idFilm')==false){
        $realisateurs = new realisateur();
        $filmRealisateur = $realisateurs->getFilmByIdRealisateur($idRealisateur);
        // print_r($realisateurs->getFilmByIdRealisateur($idRealisateur));
        // exit;
        
        $idFilm=$filmRealisateur[0]['id'];
        // print_r($idFilm);
        // exit;
    }else{
        $idFilm=request('idFilm');
        $realisateurs = new realisateur();
        $filmRealisateur = $realisateurs->getFilmByIdRealisateur($idRealisateur);
        // print_r($realisateurs->getFilmByIdRealisateur($idRealisateur));
        // exit;
    }
    // $lieux=new lieu();
    // $tabLieux=$lieux->getByFilmId($id);

    $film=new film();
    $allFilm=$film->getById($idFilm);
    /*print_r($allFilm);*/

     $listFilm=$filmRealisateur;



    for ($i=0; $i < count($listFilm); $i++) {
         # code...
        $listFilm[$i]['URL']=URL_SITE.'index.php?action=viewByRealisateurId&idFilm='.$listFilm[$i]['id'].'&idRealisateur='.$idRealisateur;

        $listFilm[$i]['active'] = false;
        if($listFilm[$i]['id'] == $idFilm){
            $listFilm[$i]['active'] = true;
        }
    }
    $cssMap="<link rel='stylesheet' href='assets/css/stylemap.css' />";

    echo $m->render('header.inc', array('css'=>$cssMap));
    echo $m->render('map.inc', array('Film' => $listFilm,"URL"=>URL_SITE."index.php?action=viewByRealisateurId&idRealisateur=".$idRealisateur."&idFilm="));
    echo $m->render('mapleaflet',$allFilm);
}

echo $m->render('footer.inc');
// testTMDB();
