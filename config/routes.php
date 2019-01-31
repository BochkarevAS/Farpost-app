<?php

/**
 * Вот нехуй выдумывать открываем сорцы Симфони Ларавель Спринг и смотрим
 */
return [
    'user/registration' => [\App\Controller\UserController::class, 'actionRegistration'],
    'user/login' => [\App\Controller\UserController::class, 'actionLogin'],
    'user/confirm' => [\App\Controller\UserController::class, 'actionConfirm'],
    'user/logout' => [\App\Controller\UserController::class, 'actionLogout'],
    'image/index' => ['_controller' => \App\Controller\ImageController::class, 'index'],
    'image/create' => ['_controller' => \App\Controller\ImageController::class, 'create'],
    'image/show/([0-9]+)' => ['_controller' => \App\Controller\ImageController::class, 'show'],
    '' => [\App\Controller\UserController::class, 'actionIndex']
];