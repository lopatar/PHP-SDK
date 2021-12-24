<?php

namespace sdk\routing;

require_once __DIR__ . '/../http/request.php';
require_once __DIR__ . '/../http/response.php';

use sdk\http\request as request;
use sdk\http\response as response;

class route
{
    private string $request_uri;
    private array $request_uri_parts;
    private array $request_methods;
    private array $request_uri_parameters = [];
    private $callback;
    
    public function __construct(string $request_uri, array $methods, callable $callback)
    {        
        $this->request_uri = $request_uri;
        $this->request_uri_parts = explode('/', $request_uri);
        $this->request_methods = $methods;
        $this->callback = $callback;
    }
    
    public function match(request $request) : bool
    {
        $curr_request_uri = $request->get_server_var('REQUEST_URI');
        
        if (!in_array($request->get_server_var('REQUEST_METHOD'), $this->request_methods))
        {
            return false;
        }
        
        if ($this->has_parameters())
        {
           $curr_request_uri_parts = explode('/', $curr_request_uri);
           
           if (count($curr_request_uri_parts) !== count($this->request_uri_parts))
           {
               return false;
           }
           
           $parameters = $this->get_parameters();
           
           if ($this->uri_except_params($curr_request_uri_parts, $parameters) !== $this->uri_except_params($this->request_uri_parts, $parameters))
           {
               return false;
           }
           
           foreach ($parameters as $name => $index)
           {
               if (empty($curr_request_uri_parts[$index]))
               {
                   return false;
               }
               $name = str_replace(['{', '}'], '', $name);
               $this->request_uri_parameters[$name] = $curr_request_uri_parts[$index];
           }
        }
        else
        {
            if ($curr_request_uri !== $this->request_uri)
            {
                return false;
            }
        }
        
        return true;
    }
    
    private function get_parameters() : array
    {
        $indices = [];
        
        for ($i = 0; $i < count($this->request_uri_parts); $i++)
        {
            $uri_part = $this->request_uri_parts[$i];
            
            if (empty($uri_part))
            {
                continue;
            }
            
            if ($uri_part[0] === '{')
            {
                $indices[$uri_part] = $i;
            }
        }
        
        return $indices;
    }
    
    private function uri_except_params(array $request_uri_parts, array $indices) : string
    {
        $new_uri = '';
        
        for ($i = 0; $i < count($request_uri_parts); $i++)
        {
            if (in_array($i, $indices))
            {
                continue;
            }
            
            $new_uri .= $request_uri_parts[$i];
        }
        
        return $new_uri;
    }
    
    private function has_parameters() : bool
    {   
        foreach ($this->request_uri_parts as $uri_part)
        {   
            if (empty($uri_part))
            {
                continue;
            }
            
            if ($uri_part[0] === '{')
            {
                return true;
            }
        }
        
        return false;
    }
    
    public function execute(request $request) : response
    {
        $response = new response();
        return call_user_func_array($this->callback, [$request, $response, $this->request_uri_parameters]);
    }
}