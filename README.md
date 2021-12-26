# About

This PHP SDK has been created for the sole purpose of me trying to understand PHP frameworks by mimicing their features on my own.

# Usage

Most accurate usage info can be seen in the [public/index.php](https://github.com/lopatar/PHP-SDK/blob/master/public/index.php) file. 
However here's a quick paste of the current file contents.

```
<?php

require __DIR__ . '/../sdk/app.php';
require __DIR__ . '/../app/middleware/app.php';
require __DIR__ . '/../app/middleware/route.php';

use sdk\http\request as request;
use sdk\http\response as response;
use sdk\render\view as view;
use sdk\app as app;
use app\middleware;

$app = new app();

view::set_default_path(__DIR__ . '/../app/views/');

$app->get('/', function (request $request, response $response, array $args) : response {
    $home_view = new view('home.html');
    $response->get_body()->set_view($home_view);
    
    return $response;
});

$app->get('/test', function (request $request, response $response, array $args) : response {
    $response->get_body()->write('test route executed');
    
    return $response;
});

$app->get('/hello/{first}/{second}', function (request $request, response $response, array $args) : response {
    $first = $args['first'];
    $second = $args['second'];
    $response->get_body()->write("Hi: $first $second");
    
    return $response;
})->add_middleware(new middleware\route());

$app->add_middleware(new middleware\app());

$app->run();
```

# Usage in production

I seriously advise against using this SDK in production, because it hasn't been properly tested
