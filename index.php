<?php

session_start();

define('ROOT', __DIR__);
require_once(ROOT . '/config/autoload.php');

$routes = new Router();
$routes->run();