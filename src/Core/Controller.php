<?php

namespace App\Core;

class Controller
{
    protected $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function render($templateName, $data = [], $layoutName = 'layout/main')
    {
        $view = $this->container->get(View::class);
        $view->render($templateName, $data, $layoutName);
    }
}