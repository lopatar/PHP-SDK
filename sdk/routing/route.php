<?php

namespace sdk\routing;

require_once $GLOBALS['APP_DIR'] . 'http/request.php';
require_once $GLOBALS['APP_DIR'] . 'http/response.php';

use sdk\http;

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
    
    public function match(http\request $request) : bool
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
    
    public function execute(http\request $request) : route
    {
        $response = new http\response();
        call_user_func_array($this->callback, [$request, $response]);
        
        return $this;
    }
}