<?php

declare(strict_types=1);

namespace App\Core;

use App\Psr\ContainerInterface;
use App\Service\UploadedFile;

class Controller
{
    protected ContainerInterface $container;

    public function setContainer(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function uploaded(): UploadedFile
    {
        return $this->container->get(UploadedFile::class);
    }

    public function getSession()
    {
        return $this->container->get(Request::class)->getSession();
    }

    public function setSession(string $key, string $value)
    {
        return $this->container->get(Request::class)->setSession($key, $value);
    }

    public function redirectToRoute(string $route = '/')
    {
        return $this->container->get(Response::class)->redirectToRoute($route);
    }

    public function render($templateName, $data = [], $layoutName = 'layout')
    {
        return $this->container->get(View::class)->render($templateName, $data, $layoutName);
    }
}