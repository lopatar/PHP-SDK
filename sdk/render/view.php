<?php

namespace sdk\render;

class view
{
    private string $name;
    private static ?string $default_path = null;
    
    public function __construct(string $name, ?string $default_path = null)
    {        
        if (self::$default_path === null)
        {
            throw new \Exception('view default path must be set');   
        }
        
        $this->name = $name;
    }
    
    public static function set_default_path(string $path)
    {
        self::$default_path = $path;
    }
    
    public function render()
    {
        require self::$default_path . $this->name;
    }
}
