<?php

namespace sdk\routing;

require_once __DIR__ . '/../http/request.php';
require_once __DIR__ . '/../http/response.php';

use sdk\http\request as request;
use sdk\http\response as response;

class route
{
    private string $request_uri;
    private array $request_methods;
    private $callback;
    
    public function __construct(string $request_uri, array $methods, callable $callback)
    {
        $this->request_uri = $request_uri;
        $this->request_methods = $methods;
        $this->callback = $callback;
    }
    
    public function match(request $request) : bool
    {
        if (!in_array($request->get_header('REQUEST_METHOD'), $this->request_methods))
        {
            return false;
        }
        
        if ($request->get_header('REQUEST_URI') !== $this->request_uri)
        {
            return false;
        }
        
        return true;
    }
    
    public function execute(request $request) : response
    {
        $response = new response();
        return call_user_func_array($this->callback, [$request, $response]);
    }
}