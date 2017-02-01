
<?php
require_once "include/fonction.php";
/*require_once "include/insertBdo.php";*/
require_once "include/Mustache/Autoloader.php";
require_once "config/.init.php";
require_once "include/class/film.class.php";
require_once "include/class/realisateur.class.php";
require_once "include/class/lieu.class.php";
require_once "include/class/arrondissement.class.php";
require_once "include/class/SQL.class.php";
require_once "include/class/commentaire.class.php";
require_once "include/tmdbApi/tmdb-api.php";
Mustache_Autoloader::register();


//on explique à Mustach qu'on va utiliser comme extension le .html
$options = array('extension' => '.html');

$m = new Mustache_Engine(array(
    'loader' => new Mustache_Loader_FilesystemLoader('template', $options),
));

if (!request('action')){
     /*-----------------------------------------------------------------------
    -----------------------------------------------------------------------*/
    /*                  Affiche la home page.                           */
    /*-----------------------------------------------------------------------
    -----------------------------------------------------------------------*/
    $film = new film();
    $allFilm = $film->allFilm();
    $realisateur = new realisateur();
    $allRealisateur = $realisateur->findRealisateur();
    $arrondissement = new arrondissement();
    $allArrondissement = $arrondissement->findArrondissement();
    
	$cssAccueil = "<link rel='stylesheet' href='assets/css/style_accueil.css' />";

	echo $m->render('header.inc', 
        array(
            'css' => $cssAccueil
            ));
    echo $m->render('index.inc',
        array(
            'Film' => $allFilm,
            'URL' => URL_SITE,
            'FilmArrondissement' => $allArrondissement,
            'FilmRealisateur' => $allRealisateur 
            ));
    echo $m->render('footer.inc');

}else if(request('action') == "viewByFilmId"){

     /*-----------------------------------------------------------------------
    -----------------------------------------------------------------------*/
    /*                  Affiche tout les films.                         */
    /*-----------------------------------------------------------------------
    -----------------------------------------------------------------------*/

    $id = request('id');
    $film = new film();
    $allFilm = $film->getById($id);
    $listFilm = $film->allFilm();

    for ($i = 0; $i < count($listFilm); $i++) {
        
        $listFilm[$i]['active'] = false;

        if($listFilm[$i]['id'] == $id){
            $listFilm[$i]['active'] = true;
        }
    }

	$cssMap = "<link rel='stylesheet' href='assets/css/stylemap.css' />";

 	echo $m->render('header.inc', 
        array(
            'css' => $cssMap
            ));

    echo $m->render('map.inc', 
        array(
            'Film' => $listFilm,
            /*'BY' => '',*/
            'URL' => URL_SITE."index.php?action=viewByFilmId&id=",
            'URL_HOME' => URL_SITE
            ));

    echo $m->render('mapleaflet',$allFilm);


}else if(request('action')=='viewByArrondissementId'){

     /*-----------------------------------------------------------------------
    -----------------------------------------------------------------------*/
    /*                  Filtre film avec l'id arrondissement.           */
    /*-----------------------------------------------------------------------
    -----------------------------------------------------------------------*/

    $idArrondissement = request('idArrondissement');
    $arrondissements = new arrondissement();
        $filmArrondissement = $arrondissements->getFilmByArrondissement($idArrondissement);

    if (request('idFilm') == false){
        
        $idFilm = $filmArrondissement[0]['id'];
        
    }else{

        $idFilm = request('idFilm');
    }

    $nb_arrondissement = $arrondissements->getArrondissement($idArrondissement);
    
    $film = new film();
    $allFilm = $film->getById($idFilm);
    $allFilm["idArrondissement"] = $idArrondissement;
    $listFilm = $filmArrondissement;
    
    for ($i = 0; $i < count($listFilm); $i++) {
        
        $listFilm[$i]['active'] = false;

        if($listFilm[$i]['id'] == $idFilm){
            $listFilm[$i]['active'] = true;
        }

    }

    $cssMap = "<link rel='stylesheet' href='assets/css/stylemap.css' />";

    echo $m->render('header.inc', 
        array(
            'css' => $cssMap
            ));

    echo $m->render('map.inc', 
        array(
            'Film' => $listFilm,
            'BY' => '<span class="glyphicon glyphicon-map-marker"></span> '.$nb_arrondissement[0]['arrondissement'],
            'URL' => URL_SITE."index.php?action=viewByArrondissementId&idArrondissement=".$idArrondissement."&idFilm=",
            'URL_HOME' => URL_SITE
            ));
    
    echo $m->render('mapleaflet',$allFilm);

}else if(request('action') == 'viewByRealisateurId'){
    /*-----------------------------------------------------------------------
    -----------------------------------------------------------------------*/
    /*                  Filtre film avec l'id realisateur.              */
    /*-----------------------------------------------------------------------
    -----------------------------------------------------------------------*/
    $idRealisateur = request('idRealisateur');
    $realisateurs = new realisateur();
    $filmRealisateur = $realisateurs->getFilmByIdRealisateur($idRealisateur);

    if (request('idFilm') == false){

        $idFilm = $filmRealisateur[0]['id'];
        
    }else{

        $idFilm = request('idFilm');
        
    }
    
    $film = new film();
    $allFilm = $film->getById($idFilm);
    $listFilm = $filmRealisateur;

    for ($i = 0; $i < count($listFilm); $i++) {
       
        $listFilm[$i]['active'] = false;

        if($listFilm[$i]['id'] == $idFilm){
            $listFilm[$i]['active'] = true;
        }

    }

    $cssMap = "<link rel='stylesheet' href='assets/css/stylemap.css' />";

    echo $m->render('header.inc', 
        array(
            'css' => $cssMap
            ));
    
    echo $m->render('map.inc', 
        array(
            'Film' => $listFilm,
            'BY' => '<span class="glyphicon glyphicon-user"></span> '.$allFilm['realisateur'],
            'URL' => URL_SITE."index.php?action=viewByRealisateurId&idRealisateur=".$idRealisateur."&idFilm=",
            'URL_HOME' => URL_SITE
            ));

    echo $m->render('mapleaflet',$allFilm);

}

