<?php

class Router {

    private $routes;

    public function __construct() {
        $this->routes = include(ROOT . '/app/routes.php');
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

                $segments = explode('/', $path);
                $controllerName = ucfirst(array_shift($segments)) . "Controller";

                $action = 'action' . ucfirst(array_shift($segments));
                $controllerFile = ROOT . '/Classes/Controller/' . $controllerName . '.php';

                if (file_exists($controllerFile)) {
                    require_once($controllerFile);
                }

                $controllerObject = new $controllerName;
                $controllerObject->$action();
            }
        }
    }
}