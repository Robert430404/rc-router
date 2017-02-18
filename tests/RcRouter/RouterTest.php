<?php

namespace RcRouter\Tests;

use PHPUnit\Framework\TestCase;
use RcRouter\Exceptions\RouteNotFoundException;
use RcRouter\Exceptions\WrongHttpMethodException;
use RcRouter\Router;

/**
 * Class RouterTest
 *
 * @package RcRouter\Tests
 */
class RouterTest extends TestCase
{
    /**
     * Tests The Get Request
     */
    public function testGetRequest()
    {
        $this->expectException(WrongHttpMethodException::class);

        $router = new Router('/', 'INVALID');
        $router->get('/', function () {
            return true;
        });
    }

    /**
     * Tests The Post Request
     */
    public function testPostRequest()
    {
        $this->expectException(WrongHttpMethodException::class);

        $router = new Router('/', 'INVALID');
        $router->post('/', function () {
            return true;
        });
    }

    /**
     * Tests The Post Request
     */
    public function testPutRequest()
    {
        $this->expectException(WrongHttpMethodException::class);

        $router = new Router('/', 'INVALID');
        $router->put('/', function () {
            return true;
        });
    }

    /**
     * Tests The Post Request
     */
    public function testDeleteRequest()
    {
        $this->expectException(WrongHttpMethodException::class);

        $router = new Router('/', 'INVALID');
        $router->delete('/', function () {
            return true;
        });
    }

    /**
     * Makes sure the not found handler is used if the route is not defined.
     */
    public function testNotFound()
    {
        $this->expectException(RouteNotFoundException::class);

        $router = new Router('/', 'GET');

        $router->get('/different/route', function () {
            return true;
        });

        $router->notFound(function () {
            throw new RouteNotFoundException('There is not matching routes.');
        });
    }
}