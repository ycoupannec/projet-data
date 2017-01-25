
<?php
require_once "include/fonction.php";
require_once "include/Mustache/Autoloader.php";
Mustache_Autoloader::register();


//on explique à Mustach qu'on va utiliser comme extension le .html
$options =  array('extension' => '.html');

$m = new Mustache_Engine(array(
    'loader' => new Mustache_Loader_FilesystemLoader('template', $options),
));


echo $m->render('header');


if (!request('action')){
    $film=new film();
    $allFilm=$film->allFilm();

    for ($i=0; $i < count($allFilm); $i++) { 
         # code...
        $allFilm[$i]['URL']=URL_SITE.'index.php?action=viewByFilmId&id='.$allFilm[$i]['id'];
    }
     // print_r(array('Film' => $allFilm));
    // print_r($film ->getLieux($allFilm['id']));
     echo $m->render('index',array('Film' => $allFilm));


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
    

    echo $m->render('map', array('Film' => $listFilm));
    echo $m->render('mapleaflet',$allFilm);
}

echo $m->render('footer');
