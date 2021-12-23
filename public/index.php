<?php

const APP_DIR = '/var/www/html/digiamp.xyz/sdk/';

$GLOBALS['APP_DIR'] = APP_DIR;

require APP_DIR . 'app.php';

use sdk\http\request as request;
use sdk\http\response as response;
use sdk\app as app;

$app = new app();

$app->get('/test', function (request $request, response $response) {
    
});

$app->run();