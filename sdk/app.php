<?php

namespace sdk;

require_once __DIR__ . '/http/request.php';
require_once __DIR__ . '/http/response.php';
require_once __DIR__ . '/routing/route.php';

use sdk\http\request as request;
use sdk\http\response as response;
use sdk\routing\route as route;

class app
{
    private http\request $request;
    private http\response $response;
    private array $routes;
    
    public function __construct()
    {
        $this->request = new http\request();
        $this->response = new http\response();
    }
    
    public function run()
    {        
        foreach ($this->routes as $route)
        {
            if ($route->match($this->request))
            {
                $route->execute($this->request);
                break;
            }
        }
    }
    
    public function add_route(string $request_uri, array $methods, callable $callback) : routing\route
    {
        $route = new routing\route($request_uri, $methods, $callback);
        $this->routes[] = $route;
        
        return $route;
    }
    
    public function get(string $request_uri, callable $callback) : routing\route
    {
        return $this->add_route($request_uri, ['GET'], $callback);
    }
    
    public function head(string $request_uri, callable $callback) : routing\route
    {
        return $this->add_route($request_uri, ['HEAD'], $callback);
    }

    public function post(string $request_uri, callable $callback) : routing\route
    {
        return $this->add_route($request_uri, ['POST'], $callback);
    }

    public function put(string $request_uri, callable $callback) : routing\route
    {
        return $this->add_route($request_uri, ['PUT'], $callback);
    }
    
    public function delete(string $request_uri, callable $callback) : routing\route
    {
        return $this->add_route($request_uri, ['DELETE'], $callback);
    }        
}

