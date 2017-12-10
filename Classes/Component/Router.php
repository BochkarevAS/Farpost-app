<?php

class Router {

    private $routes;

    public function __construct() {
        $this->routes = include(ROOT . '/config/routes.php');
    }

    private function getUri() {

        if (!empty($_SERVER['REQUEST_URI'])) {
            return trim($_SERVER['REQUEST_URI'], '/');
        }
    }

    public function getRoutes() {
        $uri = $this->getUri();

        foreach ($this->routes as $route => $path) {

            if (preg_match("~$route~", $uri)) {

                $pattern = preg_replace("~$route~", $path, $uri);
                $segments = explode('/', $pattern);
                $controllerName = ucfirst(array_shift($segments)) . "Controller";

                $action = 'action' . ucfirst(array_shift($segments));
                $controllerFile = ROOT . '/Classes/Controller/' . $controllerName . '.php';

                if (file_exists($controllerFile)) {
                    require_once($controllerFile);
                }

                $controllerObject = new $controllerName;
                call_user_func_array([$controllerObject, $action], $segments);
            }
        }
    }
}