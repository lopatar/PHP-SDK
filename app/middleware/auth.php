<?php

namespace app\middleware;

require_once __DIR__ . '/../../sdk/interfaces/middleware.php';
require_once __DIR__ . '/../../sdk/http/request.php';
require_once __DIR__ . '/../../sdk/http/response.php';

use sdk\interfaces\middleware;
use sdk\http\request as request;
use sdk\http\response as response;

class auth implements middleware
{
    public function execute(request $request, response $response) : response
    {
        $header = $request->get_header('X-Auth-Key');
        
        if ($header === null)
        {
            return $this->get_unauthorized_response($response);
        }
        
        if ($header !== self::AUTH_KEY)
        {
            return $this->get_unauthorized_response($response);
        }
        
        return $response;
    }
    
    private function get_unauthorized_response(response $response) : response
    {
        $response->set_status_code(401);
        $response->get_body()->write('401 Unauthorized');
        return $response;
    }
    
    private const AUTH_KEY = 'EXAMPLE_AUTH_KEY';
}
