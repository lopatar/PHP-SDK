<?php

namespace sdk\http;

require_once __DIR__ . '/response_body.php';
require_once __DIR__ . '/request.php';

class response
{
    private array $headers = [];
    private response_body $response_body;
    
    public function __construct()
    {
        $this->response_body = new response_body();
    }
    
    public function add_header(string $name, string $value) : self
    {
       $this->headers[] = "$name: $value";
       
       return $this;
    }
    
    public function add_header_full(string $header) : self
    {
        $this->headers[] = $header;
        
        return $this;
    }
    
    public function add_headers(array $headers) : self
    {
        foreach ($headers as $header)
        {
            if (is_array($header))
            {
                $this->headers[] = "$header[0]: $header[1]";
            }
            else
            {
                $this->headers[] = $header;
            }
        }
        
        return $this;
    }
    
    public function get_body() : response_body
    {
        return $this->response_body;
    }
    
    public function send() : self
    {
        foreach ($this->headers as $header)
        {
            header($header);
        }
        
        $this->response_body->render();
        
        return $this;
    }
    
    public static function generate_404(request $request) : self
    {
        $response = new self();
        $protocol_version = $request->get_server_var('SERVER_PROTOCOL');
            
        $response->add_header_full("$protocol_version 404 Not found");
        
        return $response;
    }
}