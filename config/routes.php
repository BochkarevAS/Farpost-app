<?php

declare(strict_types=1);

use App\Controller\ImageController;
use App\Controller\MainController;

return [
    'user/registration'   => [MainController::class, 'actionRegistration'],
    'user/login'          => [MainController::class, 'actionLogin'],
    'user/confirm'        => [MainController::class, 'actionConfirm'],
    'user/logout'         => [MainController::class, 'actionLogout'],
    'image/index'         => [ImageController::class, 'index'],
    'image/create'        => [ImageController::class, 'create'],
    'image/show/([0-9]+)' => [ImageController::class, 'show'],
    '/{a}/{b}'            => [MainController::class, 'index']
];