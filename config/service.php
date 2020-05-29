<?php

declare(strict_types=1);

use App\Core\Db;
use App\Core\Response;
use App\Core\Router;
use App\Core\View;
use App\Middleware\AuthMiddleware;
use App\Psr\ContainerInterface;
use App\Service\UserService;

return [

    /**
     * Core
     */
    Router::class => function (ContainerInterface $c) {
        return new Router($c, $c->get(AuthMiddleware::class), include(ROOT . '/config/routes.php'));
    },
    Db::class => function (ContainerInterface $c) {
        return $db = Db::getInstance();
    },
    Response::class => function (ContainerInterface $c) {
        return new Response();
    },
    View::class => function (ContainerInterface $c) {
        return new View();
    },

    /**
     * Service
     */
    UserService::class => function (ContainerInterface $c) {
        return new UserService();
    },

    /**
     * Middleware
     */
    AuthMiddleware::class => function (ContainerInterface $c) {
        return new AuthMiddleware();
    },
];