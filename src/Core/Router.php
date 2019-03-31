<?php

declare(strict_types=1);

namespace App\Core;

use App\Middleware\AuthMiddleware;
use App\Psr\ContainerInterface;

class Router
{
    private $container;

    private $middleware;

    private $routes;

    public function __construct(ContainerInterface $container, AuthMiddleware $middleware, $routes)
    {
        $this->container  = $container;
        $this->middleware = $middleware;
        $this->routes     = $routes;
    }

    public function matchRequest(Request $request)
    {
        $uri = $request->getRequestUri();

        foreach ($this->routes as $route => $callable) {
            $pattern = $this->match($route);

            if (preg_match($pattern, $uri, $matches)) {
                $token = (null == $matches) ? $matches[1] : '';

                $parameters = [
                    '_controller' => $callable[0],
                    '_method'     => $callable[1],
                    '_token'      => $token,
                ];

                return $parameters;
            }
        }

        return [];
    }

    private function match(string $route)
    {
        $flag = preg_match('/\{(.+?)\}/', $route, $matches);

        if (empty($flag)) {
            return "~$route~";
        }

        $token   = "{" . $matches[1] . "}";
        $replace = "(?P<$matches[1]>[^/]++)";

        $pattern = str_replace("$token", $replace, $route);

        return "#^$pattern$#s";
    }

    public function run(Request $request)
    {

        throw new \HttpException('Not found', 404);
    }
}