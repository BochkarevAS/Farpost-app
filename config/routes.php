<?php

declare(strict_types=1);

use App\Controller\SecurityController;
use App\Controller\ImageController;
use App\Controller\MainController;
use App\Controller\HomeController;

return [
    'user/login'             => [MainController::class, 'actionLogin'],
    'user/confirm'           => [MainController::class, 'actionConfirm'],
    'image/index'            => [ImageController::class, 'index'],
    'image/create'           => [ImageController::class, 'create'],
    'image/show/([0-9]+)'    => [ImageController::class, 'show'],
    '/security/logout'       => [SecurityController::class, 'logout'],
    '/security/registration' => [SecurityController::class, 'registration'],
    '/security/login'        => [SecurityController::class, 'login'],
    '/'                      => [HomeController::class, 'index']
];