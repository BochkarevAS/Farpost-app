<?php

declare(strict_types=1);

namespace App\Core;

use App\Exceptions\InvalidArgumentException;
use App\Exceptions\NotFoundException;

class Kernel
{
    protected $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public static function classLoader($class): void
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

    /**
     * @throws NotFoundException
     * @throws InvalidArgumentException
     */
    public function handle(Request $request): void
    {
        /** @var Router $route */
        $route = $this->container->get(Router::class);
        $route->matchRequest($request);

        echo $route->run($request);
    }
}