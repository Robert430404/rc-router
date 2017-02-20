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
     * Tests The GET Request
     */
    public function testGetRequestMethodCheck()
    {
        $this->expectException(WrongHttpMethodException::class);

        $router = new Router('/', 'INVALID');
        $router->get('/', function () {
            return true;
        });
    }

    /**
     * Tests The Router For GET Request Execution
     */
    public function testGetRequestExecution()
    {
        $router  = new Router('/', 'GET');
        $request = $router->get('/', function () {
            return true;
        });

        $this->assertEquals($request, true);
    }

    /**
     * Tests The POST Request
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
     * Tests The Router For POST Request Execution
     */
    public function testPostRequestExecution()
    {
        $router  = new Router('/', 'POST');
        $request = $router->post('/', function () {
            return true;
        });

        $this->assertEquals($request, true);
    }

    /**
     * Tests The PUT Request
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
     * Tests The Router For PUT Request Execution
     */
    public function testPutRequestExecution()
    {
        $router  = new Router('/', 'PUT');
        $request = $router->put('/', function () {
            return true;
        });

        $this->assertEquals($request, true);
    }

    /**
     * Tests The DELETE Request
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
     * Tests The Router For DELETE Request Execution
     */
    public function testDeleteRequestExecution()
    {
        $router  = new Router('/', 'DELETE');
        $request = $router->delete('/', function () {
            return true;
        });

        $this->assertEquals($request, true);
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