<?php

declare(strict_types=1);

namespace App\Core;

use App\Exceptions\InvalidArgumentException;
use App\Exceptions\NotFoundException;
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

    /**
     * Обробатывает запросы.
     * Вернёт атрибуты. Например:
     * array(3) {
     *      ["_controller"] => "App\Controller\MainController"
     *      ["_method"]     => "index"
     *      ["a"]           => "1"
     *      ["b"]           => "17"
     * }
     *
     * @return $route - название маршрута из запроса
     * @throws NotFoundException
     */
    public function matchRequest(Request $request): string
    {
        foreach ($this->routes as $route => $callable) {
            $matches = $this->match($request, $route);

            if ($matches) {
                $parameters = [
                    '_controller' => $callable[0],
                    '_method'     => $callable[1]
                ];

                foreach ($matches as $key => $value) {
                    if (is_string($key)) {
                        $parameters[$key] = $matches[$key];
                    }
                }

                $request->attributes = $parameters;

                return $route;
            }
        }

        throw new NotFoundException('Страница не найдена!', 404);
    }

    /**
     * Позволяет работать с запросами вида /index/{a}/{b}
     */
    public function match(Request $request, string $route): array
    {
        $params = [];
        $uri    = $request->getRequestUri();

        preg_match_all('/\{([^}]+)\}/', $route, $matches);

        foreach (array_flip($matches[1]) as $key => $value) {
            $params[$key] = $matches[0][$value];
        }

        foreach ($params as $key => $value) {
            $route = str_replace($value, "(?P<$key>[^/]++)", $route);
        }

        preg_match("#^$route$#s", $uri, $matches);

        return $matches;
    }

    /**
     * @throws InvalidArgumentException
     */
    public function run(Request $request)
    {
        $callable  = $this->createController($request);
        $arguments = $this->createArgument($request);

        return call_user_func_array($callable, $arguments);
    }

    /**
     * Создаёт аргументы
     */
    private function createArgument(Request $request): array
    {
        $arguments  = [];
        $attributes = $request->attributes;

        $r = new \ReflectionMethod($attributes['_controller'], $attributes['_method']);

        foreach ($r->getParameters() as $param) {
            if (array_key_exists($param->name, $attributes)) {
                $arguments[] = $attributes[$param->name];
            } elseif ($param->getClass() && $param->getClass()->isInstance($request)) {
                $arguments[] = $request;
            } else {
                throw new \RuntimeException('Not arguments found');
            }
        }

        return $arguments;
    }

    /**
     * Создаёт контроллер
     *
     * @throws InvalidArgumentException
     */
    private function createController(Request $request): array
    {
        $attributes = $request->attributes;

        if (!$controller = $attributes['_controller']) {
            throw new InvalidArgumentException('Контроллер не найден', 500);
        }

        if (!$method = $attributes['_method']) {
            throw new InvalidArgumentException('Метод не найден', 500);
        }

        $controller = new $controller;

        if ($controller instanceof \App\Core\Controller) {
            $controller->setContainer($this->container);
        }

        return [$controller, $method];
    }
}