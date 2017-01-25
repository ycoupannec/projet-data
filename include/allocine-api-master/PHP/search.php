<?php

require_once(__DIR__.'/allocine.class.php');

define('ALLOCINE_PARTNER_KEY', '100043982026');
define('ALLOCINE_SECRET_KEY', '29d185d98c984a359e6e6f26a0474269');

$allocine = new Allocine(ALLOCINE_PARTNER_KEY, ALLOCINE_SECRET_KEY);

$result = $allocine->search('mon pote');

// print_r($result);
// var_dump(json_decode($result));
$test=json_decode($result, true);
// print_r($test['feed']['movie'][0]);
print_r($test);