<?php

declare(strict_types=1);

namespace App\Core;

use App\Psr\ContainerInterface;

class Container implements ContainerInterface
{
    protected $container = [];

    public function __construct($container)
    {
        $this->container = $container;
    }

    public function get(string $id)
    {
        if ($this->has($id)) {
            return $this->container[$id]($this);
        }

        return new $id();
    }

    public function has(string $id): bool
    {
        return isset($this->container[$id]);
    }

    public function bind($name, callable $callable): void
    {
        $this->container[$name] = $callable;
    }
}