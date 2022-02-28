<?php

namespace BlogApp\Router;

class Route
{
    private $path;
    private $callable;
    private $matches = [];
    private $params = [];
    private array $requirements;

    public function __construct($path, $callable, array $requirements = [])
    {
        $this->path = trim($path, '/');
        $this->callable = $callable;
        $this->requirements = $requirements;
    }

    public function matches($url)
    {
        $url = trim($url, '/');
        $path = preg_replace('#:([\w]+)#', '([^/]+)', $this->path);
        $regex = "#^$path$#i";
        if (!preg_match($regex, $url, $matches)) {
            return false;
        }
        array_shift($matches);
        $this->matches = $matches;
        return true;
    }

    public function call()
    {
        return call_user_func_array($this->callable, $this->matches);
    }
}
