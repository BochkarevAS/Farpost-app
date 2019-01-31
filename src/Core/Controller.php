<?php

namespace App\Core;

class Controller
{
    protected $view;

    public function __construct(View $view)
    {
        $this->view = $view;
    }

    public function render($templateName, $data = [], $layoutName = 'layout/main')
    {
        $this->view->render($templateName, $data, $layoutName);
    }
}