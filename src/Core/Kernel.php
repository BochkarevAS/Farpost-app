<?php

declare(strict_types=1);

namespace App\Core;

class Kernel
{
    protected $container;

    function __construct(Container $container)
    {
        $this->container = $container;
    }

    public static function classLoader($class)
    {
        $class = strtr($class, [
            'App' => 'src',
            '\\'  => DIRECTORY_SEPARATOR
        ]);

        $path = ROOT . DIRECTORY_SEPARATOR . $class . '.php';

        if (is_file($path)) {
            include_once($path);
        }
    }

    public function handle(Request $request)
    {

        /** @var Router $route */
        $route = $this->container->get(Router::class);
        $route->matchRequest($request);
        $route->run($request);



        var_dump($request);
        die;

        echo $routes->run($request);
    }
}