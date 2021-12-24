<?php

require __DIR__ . '/../sdk/app.php';

use sdk\http\request as request;
use sdk\http\response as response;
use sdk\render\view as view;
use sdk\app as app;

$app = new app();

$app->get('/', function (request $request, response $response) : response {
    $home_view = new view(__DIR__ . '/../views/home.html');
    $response->get_body()->set_view($home_view);
    
    return $response;
});

$app->get('/test', function (request $request, response $response) : response {
    $response->get_body()->write('test route executed');
    
    return $response;
});

$app->run();