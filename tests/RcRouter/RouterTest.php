<?php

namespace RcRouter\Tests;

use PHPUnit\Framework\TestCase;
use RcRouter\Exceptions\RouteNotFoundException;
use RcRouter\Exceptions\WrongHttpMethodException;
use RcRouter\Router;
use RcRouter\Utilities\Resolver;

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

        $router = new Router();
        $router->request(['GET'], '/', function () {
            return true;
        });

        new Resolver('/', 'INVALID', $router);
    }

    /**
     * Tests The Router For GET Request Execution
     */
    public function testGetRequestExecution()
    {
        $router = new Router();
        $router->request(['GET'], '/', function () {
            return true;
        });

        $resolution = (new Resolver('/', 'GET', $router))->getResolution();

        $this->assertEquals($resolution, true);
    }

    /**
     * Tests The POST Request
     */
    public function testPostRequest()
    {
        $this->expectException(WrongHttpMethodException::class);

        $router = new Router();
        $router->request(['POST'], '/', function () {
            return true;
        });

        new Resolver('/', 'INVALID', $router);
    }

    /**
     * Tests The Router For POST Request Execution
     */
    public function testPostRequestExecution()
    {
        $router = new Router();
        $router->request(['POST'], '/', function () {
            return true;
        });

        $resolution = (new Resolver('/', 'POST', $router))->getResolution();

        $this->assertEquals($resolution, true);
    }

    /**
     * Tests The PUT Request
     */
    public function testPutRequest()
    {
        $this->expectException(WrongHttpMethodException::class);

        $router = new Router();
        $router->request(['PUT'], '/', function () {
            return true;
        });

        new Resolver('/', 'INVALID', $router);
    }

    /**
     * Tests The Router For PUT Request Execution
     */
    public function testPutRequestExecution()
    {
        $router = new Router();
        $router->request(['PUT'], '/', function () {
            return true;
        });

        $resolution = (new Resolver('/', 'PUT', $router))->getResolution();

        $this->assertEquals($resolution, true);
    }

    /**
     * Tests The DELETE Request
     */
    public function testDeleteRequest()
    {
        $this->expectException(WrongHttpMethodException::class);

        $router = new Router();
        $router->request(['DELETE'], '/', function () {
            return true;
        });

        new Resolver('/', 'INVALID', $router);
    }

    /**
     * Tests The Router For DELETE Request Execution
     */
    public function testDeleteRequestExecution()
    {
        $router = new Router();
        $router->request(['DELETE'], '/', function () {
            return true;
        });

        $resolution = (new Resolver('/', 'DELETE', $router))->getResolution();

        $this->assertEquals($resolution, true);
    }

    /**
     * Makes sure the not found handler is used if the route is not defined.
     */
    public function testNotFound()
    {
        $this->expectException(RouteNotFoundException::class);

        $router = new Router();
        $router->request(['GET'], '/failed-route', function () {
            return true;
        });

        new Resolver('/', 'GET', $router);
    }
}