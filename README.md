### What Is This?

This is RC Router. This is a simple regex based router that allows you to pass variables by using
place holders in your route.

### Why Write This?

I did it flex my brain, and to get a full understanding of how routing works in the PHP space, and
rather than just reading about it and assumeing I knew what did what, I wrote this to solidify my
knowledge.

### How Does It Work?

This is (will be) a composer package (once I have the tests finished) so it relies on composer for
the autoloading of the classes. You then instanciate a new instance of the Router() object and pass
in the request URI and the request Method. 

Those can be attained from anywhere you trust. (Globals, Request Object, etc...)

```php
<?php

use RcRouter\Router;

include 'vendor/autoload.php';

$router = new Router($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);

$router->get('/', function () {
    echo 'Closure Handler Test';
});
```

### What Are Some Of The Features?

The router supports both string and integer url variables, and passes them back to you in an array.
You can extend this further (I actually built a request object that took this information and handed
you back a nice object to work with) in any way you want. The router is very flexible in how you can
use it.

You can either pass in a closure, or a named handler function.

It has a not found function that allows you to throw a 404, or do anything else, when the route is not
mapped.


### Some Examples

Simple closure based route:

```php
<?php

use RcRouter\Router;

include 'vendor/autoload.php';

$router = new Router($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);

$router->get('/', function () {
    echo 'Closure Handler Test';
});

$router->notFound(function () {
    echo '404 Catch All';
});
```

Mixed variables with a named handler:

```php
<?php

use RcRouter\Router;

include 'vendor/autoload.php';

$router = new Router($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);

$router->get('/home/{id:i}/{post:i}/{postName}', 'handler');

$router->notFound(function () {
    echo '404 Catch All';
});

function handler($mapped)
{
    var_dump($mapped);
    echo 'External Handler Test';
}
```

Mixed variables with closure:

```php
<?php

use RcRouter\Router;

include 'vendor/autoload.php';

$router = new Router($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);

$router->get('/{id:i}/{post:i}', function ($mapped) {
    echo 'found';
});

$router->notFound(function () {
    echo '404 Catch All';
});
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