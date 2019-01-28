<?php

namespace App\Core;

use Psr\Container\ContainerInterface;

class Container implements ContainerInterface
{
    protected $container = [];

    public function __construct($container)
    {
        $this->container = $container;
    }

    public function get($name)
    {
        if ($this->has($name)) {
            return $this->container[$name]($this);
        }

        return new $name();
    }

    public function has($name)
    {
        return isset($this->container[$name]);
    }

    public function set($name, callable $callable)
    {
        $this->container[$name] = $callable;
    }
}