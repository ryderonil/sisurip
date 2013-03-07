<?php

include 'config/config.php';
include 'libs/autoloader.php';
include 'libs/session.php';

//Autoloader::__autoload(get_class());

$registry = new Registry;

$registry->boostrap = new Bootstrap($registry);

$registry->boostrap->init();

?>
