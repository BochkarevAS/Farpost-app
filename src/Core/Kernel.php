<?php

namespace App\Core;

class Kernel {

    protected $container;

    function __construct(Container $container) {
        $this->container = $container;
    }

    public static function classLoader($class) {
        $class = strtr($class, [
            'App' => 'src',
            '\\' => DIRECTORY_SEPARATOR
        ]);

        $path = ROOT . DIRECTORY_SEPARATOR . $class . '.php';

        if (is_file($path)) {
            include_once($path);
        }
    }

    public function run() {
        $routes = $this->container->get(Router::class);
        echo $routes->run();
    }
}