<?php

declare(strict_types=1);

use App\Controller\ImageController;
use App\Controller\MainController;
use App\Core\Controller;
use App\Core\Db;
use App\Core\Router;
use App\Middleware\AuthMiddleware;
use App\Psr\ContainerInterface;
use App\Repository\ImageRepository;
use App\Repository\UserRepository;
use App\Service\Image;
use App\Service\User;

return [
    /**
     * Core
     */
    Controller::class => function(ContainerInterface $c) {
        $controller = new Controller();
        $controller->setContainer($c);
        return $controller;
    },
    Router::class => function(ContainerInterface $c) {
        return new Router($c, $c->get(AuthMiddleware::class), include(ROOT . '/config/routes.php'));
    },
    Db::class => function(ContainerInterface $c) {
        $dbConfig = include(ROOT . '/config/db_config.php');
        return new Db($dbConfig['host'], $dbConfig['dbname'], $dbConfig['user'], $dbConfig['password']);
    },
    /**
     * Controller
     */
    MainController::class => function(ContainerInterface $c) {
        return new MainController($c->get(User::class));
    },
    ImageController::class => function(ContainerInterface $c) {
        return new ImageController($c->get(Image::class));
    },
    /**
     * Service
     */
    User::class => function(ContainerInterface $c) {
        return new User($c->get(UserRepository::class));
    },
    Image::class => function(ContainerInterface $c) {
        return new Image($c->get(ImageRepository::class));
    },
    /**
     * Repository
     */
    UserRepository::class => function(ContainerInterface $c) {
        return new UserRepository($c->get(Db::class));
    },
    ImageRepository::class => function(ContainerInterface $c) {
        return new ImageRepository($c->get(Db::class));
    },
    /**
     * Middleware
     */
    AuthMiddleware::class => function(ContainerInterface $c) {
        return new AuthMiddleware();
    },
];