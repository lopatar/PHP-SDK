<?php

namespace sdk\http;

class request
{
    private array $post_array;
    private array $get_array;
    private array $server_array;
    private array $cookie_array;
    
    public function __construct()
    {
        $this->post_array = $_POST;
        $this->get_array = $_GET;
        $this->server_array = $_SERVER;
        $this->cookie_array = $_COOKIE;
    }
    
    public function get_post($key)
    {        
        return $this->post_array[$key] ?? null;
    }
    
    public function get_get($key)
    {
        return $this->get_array[$key] ?? null;
    }
    
    public function get_header($key)
    {
        return $this->server_array[$key] ?? null;
    }
    
    public function get_cookie($key)
    {
        return $this->cookie_array[$key] ?? null;
    }
}