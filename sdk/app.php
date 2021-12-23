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
    private request $request;
    private array $routes;
    
    public function __construct()
    {
        $this->request = new request();
    }
    
    public function run() : self
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
        
        if ($matched_route !== null)
        {
            $response = $matched_route->execute($this->request);
            $response->send();
        }
        else
        {
            $response = new response();
            $protocol_version = $this->request->get_header('SERVER_PROTOCOL');
            
            $response->add_header_full("$protocol_version 404 Not found");
            $response->send();
        }
        
        return $this;
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

