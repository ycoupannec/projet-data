<?php
require_once "../include/fonction.php";
require_once "../include/insertBdo.php";
require_once "../include/Mustache/Autoloader.php";
require_once "../include/.init.php";
require_once "../include/film.class.php";
require_once "../include/realisateur.class.php";
require_once "../include/lieu.class.php";
require_once "../include/arrondissement.class.php";
require_once "../include/SQL.class.php";
require_once "../include/commentaire.class.php";
require_once "../include/tmdb_v3-PHP-API--master/tmdb-api.php";



$data = new lieu();

print_r($data->findLieu(null," desc "));



