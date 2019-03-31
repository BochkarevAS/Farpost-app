<?php

declare(strict_types=1);

namespace App\Core;

use App\Psr\ContainerInterface;

class Controller
{
    /**
     * @var $container Container
     */
    protected $container;

    public function setContainer(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function render($templateName, $data = [], $layoutName = 'layout/main')
    {
        return $this->container->get('view')->render($templateName, $data, $layoutName);
    }
}