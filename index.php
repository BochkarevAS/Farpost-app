<?php

session_start();

define('ROOT', realpath(__DIR__ ));

require_once(ROOT . '/src/Core/Kernel.php');
spl_autoload_register('\App\Core\Kernel::classLoader');

$container = require_once(ROOT . '/config/container.php');

$kernel = new \App\Core\Kernel(new \App\Core\Container($container));
$kernel->run();