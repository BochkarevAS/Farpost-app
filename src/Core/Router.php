<?php

namespace App\Core;

use App\Middleware\AuthMiddleware;

class Router
{
    private $container;

    private $middleware;

    private $routes;

    public function __construct(Container $container, AuthMiddleware $middleware, $routes)
    {
        $this->container  = $container;
        $this->middleware = $middleware;
        $this->routes     = $routes;
    }

    public function run()
    {
        $uri = trim($_SERVER['REQUEST_URI'], '/');

        foreach ($this->routes as $route => $callable) {

            /**
             * Роутинг ещё можно улучшить !!!
             */
            if (preg_match("~$route~", $uri, $matches)) {
                $actions = ['user/registration', 'user/login', 'user/confirm'];

                if (in_array($uri, $actions)) {
                    $this->middleware->handle();
                }

                $callable['_controller'] = $this->container->get($callable['_controller']);

                $result = call_user_func_array($callable, $matches);

                return $result;
            }
        }

        /**
         * Кастомные исключения Не не слышал
         */
        throw new \HttpException('Not found', 404);
    }
}