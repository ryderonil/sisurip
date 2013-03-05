<?php

include 'config/config.php';
include 'libs/autoloader.php';

//Autoloader::__autoload(get_class());

$registry = new Registry;

$registry->boostrap = new Bootstrap($registry);

$registry->boostrap->init();

?>
