<?php

declare(strict_types=1);

session_start();

define('ROOT', realpath(__DIR__ ));

require_once(ROOT . '/src/Core/Kernel.php');
spl_autoload_register('\App\Core\Kernel::classLoader');

$container = require_once(ROOT . '/config/service.php');

try {
    $kernel = new \App\Core\Kernel(new \App\Core\Container($container));
    $request = App\Core\Request::createRequest();
    $kernel->handle($request);
} catch (\App\Exceptions\DbException $e) {
    $view = new \App\Core\View();
    echo $view->render('errors/500', ['error' => $e->getMessage()]);
} catch (\App\Exceptions\NotFoundException $e) {
    $view = new \App\Core\View();
    echo $view->render('errors/404', ['error' => $e->getMessage()]);
} catch (\App\Exceptions\InvalidArgumentException $e) {
    $view = new \App\Core\View();
    echo $view->render('errors/500', ['error' => $e->getMessage()]);
} catch (\App\Exceptions\FileException $e) {
    $view = new \App\Core\View();
    echo $view->render('errors/500', ['error' => $e->getMessage()]);
}