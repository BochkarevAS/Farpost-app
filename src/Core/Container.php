<?php

namespace App\Core;

use App\Psr\ContainerInterface;

/**
 * Контенер в принцепе норм Можно кнонечно ленивую загрузку заебенить
 * Для збора сервисов в методе get Но годится
 */
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