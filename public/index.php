<?php

require __DIR__ . '/../sdk/app.php';
require __DIR__ . '/../app/middleware/test.php';
require __DIR__ . '/../app/middleware/auth.php';

use sdk\http\request as request;
use sdk\http\response as response;
use sdk\render\view as view;
use sdk\app as app;
use app\middleware;

$app = new app();

view::set_default_path(__DIR__ . '/../app/views/');

/* Using view as a method of displaying content */
$app->get('/', function (request $request, response $response, array $args) : response {
    $home_view = new view('home.html');
    $response->get_body()->set_view($home_view);
    
    return $response;
});

/* Writing content directly into the body */
$app->get('/test', function (request $request, response $response, array $args) : response {
    $response->get_body()->write('test route executed');
    
    return $response;
})->add_middleware(new middleware\test); /* Adding example middleware */

/* Example on how parameters can be passed */
$app->get('/hello/{first}/{second}', function (request $request, response $response, array $args) : response {
    $first = $args['first'];
    $second = $args['second'];
    $response->get_body()->write("Hi: $first $second");
    
    return $response;
});

/* Example on how middleware can be used in order to authenticate users */
$app->get('/admin', function (request $request, response $response, array $args) : response {
    $response->get_body()->write('Welcome to the admin panel');
    
    return $response;
})->add_middleware(new middleware\auth);

$app->run();