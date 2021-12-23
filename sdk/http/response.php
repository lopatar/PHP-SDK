<?php

namespace sdk\http;

class response
{
    private array $headers;
    
    public function add_header(string $name, string $value) : response
    {
       $this->headers[] = "$name: $value";
       
       return $this;
    }
    
    public function add_headers(array $headers) : response
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
    
    public function send()
    {
        foreach ($this->headers as $header)
        {
            header($header);
        }
    }
}