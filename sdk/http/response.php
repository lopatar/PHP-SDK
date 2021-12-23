<?php

namespace sdk\http;

class response
{
    private array $headers;
    private string $body;
    
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
            if (count($header) === 1)
            {
                $this->headers[] = $header;
            }
            else
            {
                $this->headers[] = "$header[0]: $header[1]";
            }
        }
        
        return $this;
    }
    
    public function set_body(string $body) : self
    {
        $this->body = $body;
        
        return $this;
    }
    
    public function send() : self
    {
        if (!empty($this->headers))
        {
            foreach ($this->headers as $header)
            {
                header($header);
            }
        }
        
        echo $this->body;
        
        return $this;
    }
}