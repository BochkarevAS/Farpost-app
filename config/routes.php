<?php

declare(strict_types=1);

use App\Controller\RegistrationController;
use App\Controller\SecurityController;
use App\Controller\HomeController;
use App\Controller\UserController;

return [
    '/user/list'             => [UserController::class, 'index'],
    '/user/{id}/show'        => [UserController::class, 'show'],
    '/user/{id}/edit'        => [UserController::class, 'edit'],
    '/user/{id}/delete'      => [UserController::class, 'delete'],
    '/user/create'           => [UserController::class, 'create'],
    '/registration/register' => [RegistrationController::class, 'register'],
    '/security/logout'       => [SecurityController::class, 'logout'],
    '/security/login'        => [SecurityController::class, 'login'],
    '/'                      => [HomeController::class, 'index']
];