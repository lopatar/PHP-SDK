<?php

namespace app\middleware;

require_once __DIR__ . '/../../sdk/interfaces/middleware.php';
require_once __DIR__ . '/../../sdk/http/request.php';
require_once __DIR__ . '/../../sdk/http/response.php';

use sdk\interfaces\middleware;
use sdk\http\request as request;
use sdk\http\response as response;

class route implements middleware
{
    public function execute(request $request, response $response) : response
    {
        $response->get_body()->write('Route middleware executed ');
        return $response;
    }
}
