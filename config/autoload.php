<?php

    function __autoload($class) {

        $paths = [
            '/Classes/Component/',
            '/Classes/Service/'
        ];

        foreach ($paths as $path) {
            $path = ROOT . $path . $class . '.php';

            if (is_file($path)) {
                include_once($path);
            }
        }
    }