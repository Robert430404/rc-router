<?php

namespace RcRouter\Tests;

use PHPUnit\Framework\TestCase;
use RcRouter\Exceptions\RouteNotFoundException;
use RcRouter\Exceptions\WrongHttpMethodException;
use RcRouter\Router;
use RcRouter\Utilities\Parser;
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

        new Resolver('/', 'INVALID', $router, new Parser());
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

        $resolution = (new Resolver('/', 'GET', $router, new Parser()))->getResolution();

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

        new Resolver('/', 'INVALID', $router, new Parser());
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

        $resolution = (new Resolver('/', 'POST', $router, new Parser()))->getResolution();

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

        new Resolver('/', 'INVALID', $router, new Parser());
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

        $resolution = (new Resolver('/', 'PUT', $router, new Parser()))->getResolution();

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

        new Resolver('/', 'INVALID', $router, new Parser());
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

        $resolution = (new Resolver('/', 'DELETE', $router, new Parser()))->getResolution();

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

        new Resolver('/', 'GET', $router, new Parser());
    }

    /**
     * Makes sure query string parsing works on simple routes
     */
    public function testWorkingQueryStringRoute()
    {
        $router = new Router();
        $router->request(['GET'], '/?test=test', function () {
            return true;
        });

        $resolution = (new Resolver('/?test=test', 'GET', $router, new Parser()))->getResolution();

        $this->assertEquals($resolution, true);
    }

    /**
     * Makes sure query string parsing works on simple routes
     */
    public function testLongerWorkingQueryStringRoute()
    {
        $router = new Router();
        $router->request(['GET'], '/home/?test=test', function () {
            return true;
        });

        $resolution = (new Resolver('/home/?test=test', 'GET', $router, new Parser()))->getResolution();

        $this->assertEquals($resolution, true);
    }

    /**
     * Makes sure unmatched query string routes throw exception
     */
    public function testBrokenQueryStringRoute()
    {
        $this->expectException(RouteNotFoundException::class);

        $router = new Router();
        $router->request(['GET'], '/home?test=test', function () {
            return true;
        });

        new Resolver('/?test=test', 'GET', $router, new Parser());
    }

    /**
     * Makes sure query string parsing works on simple routes
     */
    public function testWorkingRegexRoute()
    {
        $router = new Router();
        $router->request(['GET'], '/home/{string}/{id:i}', function () {
            return true;
        });

        $resolution = (new Resolver('/home/test/1', 'GET', $router, new Parser()))->getResolution();

        $this->assertEquals($resolution, true);
    }

    /**
     * Makes sure unmatched query string routes throw exception
     */
    public function testBrokenRegexRoute()
    {
        $this->expectException(RouteNotFoundException::class);

        $router = new Router();
        $router->request(['GET'], '/home/{string}/{id:i}', function () {
            return true;
        });

        new Resolver('/broken/test/1', 'GET', $router, new Parser());
    }

    /**
     * Makes sure unmatched query string routes throw exception
     */
    public function testMisMatchedRegexRoute()
    {
        $this->expectException(RouteNotFoundException::class);

        $router = new Router();
        $router->request(['GET'], '/home/{string}/{id:i}/{id:i}', function () {
            return true;
        });

        new Resolver('/broken/test/1', 'GET', $router, new Parser());
    }
}