<?php

require __DIR__ . '/../sdk/app.php';

use sdk\http\request as request;
use sdk\http\response as response;
use sdk\app as app;

$app = new app();

$app->get('/test', function (request $request, response $response) : response {
    $response->set_body('test route');
    return $response;
});

$app->run();