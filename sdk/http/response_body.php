<?php

namespace sdk\http;

require_once __DIR__ . '/../render/view.php';

use sdk\render\view;

class response_body
{
    private ?string $text = null;
    private ?view $view = null;
    
    public function set_view(view $view) : self
    {
        if ($this->text !== null)
        {
            $this->text = null;
        }
        
        $this->view = $view;
        
        return $this;
    }
    
    public function write(string $text) : self
    {
        if ($this->view !== null)
        {
            $this->view = null;
        }
        
        $this->text = $text;
        
        return $this;
    }
    
    public function get_view()
    {
        return $this->view ?? null;
    }
    
    public function get_text()
    {
        return $this->text ?? null;
    }
    
    public function render() : self
    {
        if ($this->view !== null)
        {
            $this->view->render();
        }
        
        if ($this->text !== null)
        {
            echo $this->text;
        }
        
        return $this;
    }
}