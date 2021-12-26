<?php

namespace sdk\http;

class request
{
    private array $post_array;
    private array $get_array;
    private array $server_array;
    private array $cookie_array;
    private array $headers;
    
    public function __construct()
    {
        $this->post_array = $_POST;
        $this->get_array = $_GET;
        $this->server_array = $_SERVER;
        $this->cookie_array = $_COOKIE;
        $this->headers = getallheaders();
    }
    
    public function get_post(string $key)
    {        
        return $this->post_array[$key] ?? null;
    }
    
    public function get_get(string $key)
    {
        return $this->get_array[$key] ?? null;
    }
    
    public function get_header(string $key)
    {
        return $this->headers[$key] ?? null;
    }
    
    public function get_headers() : array
    {
        return $this->headers;
    }
    
    public function get_server_var(string $key)
    {
        return $this->server_array[$key] ?? null;
    }
    
    public function get_cookie(string $key)
    {
        return $this->cookie_array[$key] ?? null;
    }
}