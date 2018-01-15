<?php

return [
    'user/registration' => [\App\Controller\UserController::class, 'actionRegistration', \App\Middleware\AuthMiddleware::class],
    'user/login' => [\App\Controller\UserController::class, 'actionLogin', \App\Middleware\AuthMiddleware::class],
    'user/confirm' => [\App\Controller\UserController::class, 'actionConfirm', \App\Middleware\AuthMiddleware::class],
    'user/logout' => [\App\Controller\UserController::class, 'actionLogout'],
    'user/image' => [\App\Controller\ImageController::class, 'actionIndex'],
    'user/addAjaxImage' => [\App\Controller\ImageController::class, 'actionAddAjaxImage'],
    'user/show/([0-9]+)' => [\App\Controller\ImageController::class, 'actionShow'],
    '' => [\App\Controller\UserController::class, 'actionIndex']
];