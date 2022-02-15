<?php
namespace BlogApp\Router;

class Router 
{
	private $url;
	private $routes = [];
	
	public function __construct($urlP, $urlId = null , $urlPage = null)
	{
		$this->url = trim($urlP, '/') ;
        if ($urlId)
        {
            $this->url .= '/'.$urlId;
            if ($urlPage)
            {
                $this->url .= '/'.$urlPage;
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
        // Absence de method
		if(!isset($this->routes[$_SERVER['REQUEST_METHOD']]))
		{
            $message =  'request method doesnt exist';
			//throw new RouterException('request method doesnt exist');
		}

		// Appel dynamique de la route
		foreach($this->routes[$_SERVER['REQUEST_METHOD']] as $route)
		{
            // On passe $this->url pour effectuer le test
			if($route->matches($this->url))
			{
				return $route->call();
			}
		}

        // Absence de resulat
		return header('HTTP/1.0 404 Not Found');
		// throw new RouterException('No routes matches');
	}
}
