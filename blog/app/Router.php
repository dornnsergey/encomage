<?php

namespace App;

use App\Exceptions\ActionNotFoundException;
use App\Exceptions\RouteNotFoundException;

class Router
{
    protected array $routes = [];

    public function get(string $route, array $action)
    {
        $this->routes['get'][$route] = $action;
    }

    public function post(string $route, array $action)
    {
        $this->routes['post'][$route] = $action;
    }

    public function resolve(string $requestUri, string $requestMethod)
    {
        $route = preg_replace('#\?.*#', '', $requestUri);

        $action = $this->routes[$requestMethod][$route] ?? null;

        if (! $action) {
            throw new RouteNotFoundException();
        }

        [$class, $method] = $action;

        if (! class_exists($class)) {
            throw new ActionNotFoundException('Action Class Not Found.');
        }

        $class = new $class();

        if (! method_exists($class, $method)) {
            throw new ActionNotFoundException('Action Method Not Found.');
        }

        return call_user_func([$class, $method]);
    }
}