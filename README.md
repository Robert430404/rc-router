[![Latest Stable Version](https://poser.pugx.org/robert430404/rc-router/v/stable)](https://packagist.org/packages/robert430404/rc-router)
[![Build Status](https://travis-ci.org/Robert430404/rc-router.svg?branch=master)](https://travis-ci.org/Robert430404/rc-router)
[![codecov](https://codecov.io/gh/Robert430404/rc-router/branch/master/graph/badge.svg)](https://codecov.io/gh/Robert430404/rc-router)

### What Is This?

This is RC Router. This is a simple regex based router that allows you to pass variables by using
place holders in your route.

### Why Write This?

I did it to flex my brain, and get a full understanding of how routing works in the PHP space. Rather
than just reading about it and assuming I knew what did what, I wrote this to solidify my
knowledge.

### Installing The Package

Simply use composer:

    composer require robert430404/rc-router

### How Does It Work?

This is a composer package so it relies on composer for the autoloading of the classes. You then
create a new instance of the Router() object and start assigning your routes to the instance. Once
you have your routes defined, you then pass the Router() into the Resolver() and it handles your
routes.

```php
<?php

use RcRouter\Router;
use RcRouter\Utilities\Resolver;
use RcRouter\Exceptions\RouteNotFoundException;

include 'vendor/autoload.php';

$router = new Router();

$router->request(['GET'], '/', function () {
    echo 'Closure Handler Test';
});

$uri    = $_SERVER['REQUEST_URI'];    // You do not have to use globals here if you have access to a different source.
$method = $_SERVER['REQUEST_METHOD']; // You simply need to pass these (uri and method) as strings to the Resolver.

try {
    new Resolver($uri, $method, $router);
} catch (RouteNotFoundException $e) {
    echo '404 not found';
}
```

### What Are Some Of The Features?

The router supports both string and integer url variables, and passes them back to you in an array.
You can extend this further in any way you want. The router is very flexible in how you can use it.

You can either pass in a closure, or a named handler function to each route to control what happens
when a route is matched.

When a route is not found, a RouteNotFoundException is thrown from the resolver and allows you to catch
and then create your 404 handler. 


### Some Examples

Simple closure based route:

```php
<?php

use RcRouter\Router;
use RcRouter\Utilities\Resolver;
use RcRouter\Exceptions\RouteNotFoundException;

include 'vendor/autoload.php';

$router = new Router();

$router->request(['GET'], '/', function () {
    echo 'Closure Handler Test';
});

$uri    = $_SERVER['REQUEST_URI'];    // You do not have to use globals here if you have access to a different source.
$method = $_SERVER['REQUEST_METHOD']; // You simply need to pass these (uri and method) as strings to the Resolver.

try {
    new Resolver($uri, $method, $router);
} catch (RouteNotFoundException $e) {
    echo '404 not found';
}
```

Simple route with a named handler:

```php
<?php

use RcRouter\Router;
use RcRouter\Utilities\Resolver;
use RcRouter\Exceptions\RouteNotFoundException;

include 'vendor/autoload.php';

$router = new Router();

$router->request(['GET'], '/', 'handler');

$uri    = $_SERVER['REQUEST_URI'];    // You do not have to use globals here if you have access to a different source.
$method = $_SERVER['REQUEST_METHOD']; // You simply need to pass these (uri and method) as strings to the Resolver.

try {
    new Resolver($uri, $method, $router);
} catch (RouteNotFoundException $e) {
    echo '404 not found';
}

function handler()
{
    echo 'External Handler Test';
}
```

Regex closure based route with variables:

```php
<?php

use RcRouter\Router;
use RcRouter\Utilities\Resolver;
use RcRouter\Exceptions\RouteNotFoundException;

include 'vendor/autoload.php';

$router = new Router();

$router->request(['GET'], '/{id:i}/{post:i}', function ($mapped) {
    echo '<pre>';
    var_dump($mapped);
    echo '</pre>';

    echo 'Route Found';
});

$uri    = $_SERVER['REQUEST_URI'];    // You do not have to use globals here if you have access to a different source.
$method = $_SERVER['REQUEST_METHOD']; // You simply need to pass these (uri and method) as strings to the Resolver.

try {
    new Resolver($uri, $method, $router);
} catch (RouteNotFoundException $e) {
    echo '404 not found';
}
```

Regex route with variables and external handler:

```php
<?php

use RcRouter\Router;
use RcRouter\Utilities\Resolver;
use RcRouter\Exceptions\RouteNotFoundException;

include 'vendor/autoload.php';

$router = new Router();

$router->request(['GET'], '/{id:i}/{post:i}', 'handler');

$uri    = $_SERVER['REQUEST_URI'];    // You do not have to use globals here if you have access to a different source.
$method = $_SERVER['REQUEST_METHOD']; // You simply need to pass these (uri and method) as strings to the Resolver.

try {
    new Resolver($uri, $method, $router);
} catch (RouteNotFoundException $e) {
    echo '404 not found';
}

function handler($mapped)
{
    echo '<pre>';
    var_dump($mapped);
    echo '</pre>';
    
    echo 'Route Found';
}
```

### What Is In The Returned Values?

The "$mapped" variable returns a structure like this:

```php
<?php

$mapped = [
    'all' => [
        'id'   => 0,
        'name' => 'Robert'
    ],
    'int' => [
        'id' => 0
    ],
    'string' => [
        'name' => 'Robert'
    ],
];
```