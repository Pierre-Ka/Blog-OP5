<?php

namespace BlogApp\Router;

class Router
{
    private $url;
    private $routes = [];

    public function __construct($urlP, $urlId = null, $urlPage = null)
    {
        $this->url = trim($urlP, '/');
        if (null !== $urlId) {
            $this->url .= '/' . $urlId;
            if (null !== $urlPage) {
                $this->url .= '/' . $urlPage;
            }
        }
    }

    public function get($path, $callable, array $requirements = [])
    {
        $route = new Route($path, $callable, $requirements);
        $this->routes['GET'][] = $route;
    }

    public function post($path, $callable)
    {
        $route = new Route($path, $callable);
        $this->routes['POST'][] = $route;
    }

    public function run()
    {
        if (!isset($this->routes[$_SERVER['REQUEST_METHOD']])) {
            $message = 'request method doesnt exist';
        }
        foreach ($this->routes[$_SERVER['REQUEST_METHOD']] as $route) {
            if ($route->matches($this->url)) {
                return $route->call();
            }
        }
    }
}
