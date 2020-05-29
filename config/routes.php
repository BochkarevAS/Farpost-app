<?php

declare(strict_types=1);

use App\Controller\SecurityController;
use App\Controller\ImageController;
use App\Controller\MainController;
use App\Controller\HomeController;
use App\Controller\UserController;

return [
    '/user/list'             => [UserController::class, 'index'],
    '/user/{id}/show'        => [UserController::class, 'show'],
    '/user/{id}/edit'        => [UserController::class, 'edit'],
    '/user/{id}/delete'      => [UserController::class, 'delete'],
    '/user/create'           => [UserController::class, 'create'],
    'user/login'             => [MainController::class, 'actionLogin'],
    'user/confirm'           => [MainController::class, 'actionConfirm'],
    '/image/index'           => [ImageController::class, 'index'],
    'image/create'           => [ImageController::class, 'create'],
    'image/show/([0-9]+)'    => [ImageController::class, 'show'],
    '/security/logout'       => [SecurityController::class, 'logout'],
    '/security/registration' => [SecurityController::class, 'registration'],
    '/security/login'        => [SecurityController::class, 'login'],
    '/'                      => [HomeController::class, 'index']
];