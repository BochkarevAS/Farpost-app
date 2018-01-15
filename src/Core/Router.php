<?php

namespace App\Core;

class Router {

    private $routes;
    private $container;

    public function __construct(Container $container, $routes) {
        $this->container = $container;
        $this->routes = $routes;
    }

    public function run() {
        $uri = trim($_SERVER['REQUEST_URI'], '/');

        foreach ($this->routes as $route => $callable) {
            if (preg_match("~$route~", $uri, $matches)) {

                if (count($callable) === 2) {
                    $callable[0] = $this->container->get($callable[0]);
                } elseif (count($callable) === 3) {
                    $this->container->get($callable[2])->handle();
                    array_pop($callable);
                    $callable[0] = $this->container->get($callable[0]);
                }

                $result = call_user_func_array($callable, $matches);
                return $result;
            }
        }

        throw new \HttpException('Not found', 404);
    }
}