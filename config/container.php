<?php

return [
    \App\Core\Router::class => function($c) {
        return new \App\Core\Router($c, include(ROOT . '/config/routes.php'));
    },
    \App\Controller\UserController::class => function($c) {
        return new \App\Controller\UserController($c->get(\App\Core\View::class), $c->get(\App\Service\UserService::class));
    },
    \App\Controller\ImageController::class => function($c) {
        return new \App\Controller\ImageController($c->get(\App\Core\View::class), $c->get(\App\Service\Image::class));
    },
    \App\Service\UserService::class => function($c) {
        return new \App\Service\UserService($c->get(\App\Repository\UserRepository::class));
    },
    \App\Service\Image::class => function($c) {
        return new \App\Service\Image($c->get(\App\Repository\ImageRepository::class));
    },
    \App\Repository\UserRepository::class => function($c) {
        return new \App\Repository\UserRepository($c->get(\App\Core\Db::class));
    },
    \App\Repository\ImageRepository::class => function($c) {
        return new \App\Repository\ImageRepository($c->get(\App\Core\Db::class));
    },
    \App\Core\Db::class => function($c) {
        $dbConfig = include(ROOT . '/config/db_config.php');
        return new \App\Core\Db($dbConfig['host'], $dbConfig['dbname'], $dbConfig['user'], $dbConfig['password']);
    },
    \App\Middleware\AuthMiddleware::class => function($c) {
        return new \App\Middleware\AuthMiddleware();
    }
];