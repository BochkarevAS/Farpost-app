<?php

class Routes {

    private $routes;

    public function __construct() {
        $this->routes = include(ROOT . '/src/routes.php');
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
                $path = ROOT . $path . '.php';

                if (file_exists($path)) {
                    require_once($path);
                    return;
                }
            }
        }
    }
}