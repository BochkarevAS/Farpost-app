<?php

declare(strict_types=1);

namespace App\Core;

class Response
{
    public function redirectToRoute(string $route = '/')
    {
        header('Location: ' . $route);
        die;
    }
}