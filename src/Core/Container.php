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

    public function get($id)
    {
        if ($this->has($id)) {
            return $this->container[$id]($this);
        }

        return new $id();
    }

    public function has($id)
    {
        return isset($this->container[$id]);
    }

    public function bind($name, callable $callable)
    {
        $this->container[$name] = $callable;
    }
}