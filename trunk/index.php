<?php

include 'config/config.php';
include 'libs/autoloader.php';

$registry = new Registry;

$registry->boostrap = new Bootstrap($registry);

$registry->boostrap->init();

?>
