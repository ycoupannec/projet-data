
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

    for ($i=0; $i < count($allFilm); $i++) { 
         # code...
        // à ajouter à la class film : get url
        $allFilm[$i]['URL']=URL_SITE.'index.php?action=viewByFilmId&id='.$allFilm[$i]['id'];
    }
     // print_r(array('Film' => $allFilm));
    // print_r($film ->getLieux($allFilm['id']));
		$cssAccueil="<link rel='stylesheet' href='assets/css/style_accueil.css' />";

	 echo $m->render('header.inc', array('css'=>$cssAccueil));
     echo $m->render('index.inc',array('Film' => $allFilm, "URL"=>URL_SITE));

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
    echo $m->render('map.inc', array('Film' => $listFilm,"URL"=>URL_SITE));
    echo $m->render('mapleaflet',$allFilm);
}

echo $m->render('footer.inc');
// testTMDB();
