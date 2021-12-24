<?php

namespace sdk\render;

class view
{
    private string $path;
    
    public function __construct(string $path)
    {
        $this->path = $path;
    }
    
    public function render() : self
    {
        require $this->path;
        
        return $this;
    }
}
