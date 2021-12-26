<?php

namespace sdk;

require_once __DIR__ . '/http/request.php';
require_once __DIR__ . '/http/response.php';
require_once __DIR__ . '/routing/route.php';
require_once __DIR__ . '/render/view.php';
require_once __DIR__ . '/interfaces/middleware.php';

use sdk\http\request as request;
use sdk\http\response as response;
use sdk\routing\route as route;
use sdk\interfaces\middleware as middleware;

class app
{
    private request $request;
    private response $response;
    private array $routes = [];
    private array $middleware = [];
    
    public function __construct()
    {
        $this->request = new request();
        $this->response = new response();
    }
    
    public function run()
    {   
        $this->run_middleware();
        $matched_route = $this->match_route();
        
        if ($matched_route !== null)
        {
            $this->response = $matched_route->execute($this->request, $this->response);
        }
        else
        {
           $this->response->set_status_code(404);
        }
        
        $this->response->send();
    }
    
    public function add_middleware(middleware $middleware) : self
    {        
        $this->middleware[] = $middleware;
        
        return $this;
    }
    
    
    public function add_middleware_array(array $middleware_array) : self
    {
        foreach ($middleware_array as $middleware)
        {
            $this->add_middleware($middleware);
        }
        
        return $this;
    }
    
    private function run_middleware()
    {
        foreach ($this->middleware as $middleware)
        {
            $this->response = $middleware->execute($this->request, $this->response);
        }
    }
    
    private function match_route() : ?route
    {
        $matched_route = null;
        
        foreach ($this->routes as $route)
        {
            if ($route->match($this->request))
            {
                $matched_route = $route;
                break;
            }
        }
        
        return $matched_route;
    }
    
    public function add_route(string $request_uri, array $methods, callable $callback) : route
    {
        $route = new route($request_uri, $methods, $callback);
        $this->routes[] = $route;
        
        return $route;
    }
    
    public function get(string $request_uri, callable $callback) : route
    {
        return $this->add_route($request_uri, ['GET'], $callback);
    }
    
    public function head(string $request_uri, callable $callback) : route
    {
        return $this->add_route($request_uri, ['HEAD'], $callback);
    }

    public function post(string $request_uri, callable $callback) : route
    {
        return $this->add_route($request_uri, ['POST'], $callback);
    }

    public function put(string $request_uri, callable $callback) : route
    {
        return $this->add_route($request_uri, ['PUT'], $callback);
    }
    
    public function delete(string $request_uri, callable $callback) : route
    {
        return $this->add_route($request_uri, ['DELETE'], $callback);
    }        
}

