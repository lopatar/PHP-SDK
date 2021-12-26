<?php

namespace sdk\interfaces;

require_once __DIR__ . '/../http/request.php';
require_once __DIR__ . '/../http/response.php';

use sdk\http\response as response;
use sdk\http\request as request;

interface middleware
{
    public function execute(request $request, response $response) : response;
}
