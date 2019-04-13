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

    /**
     * Обробатывает запросы.
     * Вернёт атрибуты. Например:
     * array(3) {
     *      ["_controller"]=> "App\Controller\MainController"
     *      ["_method"]    => "index"
     *      ["attributes"] => { ["a"]=> "1" ["b"]=>"17" }
     * }
     */
    public function matchRequest(Request $request)
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
                        $parameters['attributes'][$key] = $matches[$key];
                    }
                }

                $request->attributes = $parameters;

                return;
            }
        }

        throw new \HttpException('Not found', 404);
    }

    /**
     * Позволяет работать с запросами вида /index/{a}/{b}
     */
    private function match(Request $request, string $route)
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

    public function run(Request $request)
    {
        if (!$class = $request->attributes['_controller']) {
            throw new \InvalidArgumentException('Not controller found');
        }

        if (!$method = $request->attributes['_method']) {
            throw new \InvalidArgumentException('Not method found');
        }

//        var_dump(class_exists($controller));
//        die;

        if (class_exists($class)) {
//            $controller = new $class;
        }

        $controller = new $class;

        if (is_array($controller)) {
            $r = new \ReflectionMethod($controller[0], $controller[1]);
        };

//        var_dump($controller);
        var_dump($r->getParameters());
        die;

//        $response = call_user_func_array($controller, $arguments);

        throw new \HttpException('Not found', 404);
    }
}