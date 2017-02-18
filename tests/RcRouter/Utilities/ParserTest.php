<?php

namespace RcRouter\Tests\Utilities;

use PHPUnit\Framework\TestCase;
use RcRouter\Utilities\Parser;

/**
 * Class ParserTest
 *
 * @package RcRouter\Tests\Utilities
 */
class ParserTest extends TestCase
{
    /**
     * Tests the simple route matching of the parser.
     */
    public function testSimpleRoutes()
    {
        $parser = new Parser('/');
        $route  = $parser->parse('/', function () {
            return true;
        });

        $this->assertEquals($route, true);
    }

    /**
     * Tests the query string matching on simple routes
     */
    public function testQueryStringRoute()
    {
        $parser = new Parser('/');
        $route  = $parser->parse('/?test=this-test-is-awesome', function () {
            return true;
        });

        $this->assertEquals($route, true);
    }

    /**
     * Tests integer regex parsing
     */
    public function testIntegerRegexRoute()
    {
        $parser = new Parser('/{id:i}/{post:i}');
        $route  = $parser->parse('/1/32', function () {
            return true;
        });

        $this->assertEquals($route, true);
    }

    /**
     * Tests string regex parsing
     */
    public function testStringRegexRoute()
    {
        $parser = new Parser('/{id}/{post}');
        $route  = $parser->parse('/1/32', function () {
            return true;
        });

        $this->assertEquals($route, true);
    }

    /**
     * Tests mixed regex parsing
     */
    public function testMixedRegexRoute()
    {
        $parser = new Parser('/{id:i}/{post:i}/{postName}');
        $route  = $parser->parse('/1/32/best-post-ever', function () {
            return true;
        });

        $this->assertEquals($route, true);
    }

    /**
     * Tests integer regex parsing with query string
     */
    public function testIntegerRegexRouteWithQueryString()
    {
        $parser = new Parser('/{id:i}/{post:i}');
        $route  = $parser->parse('/1/32?test=this-is-a-test', function () {
            return true;
        });

        $this->assertEquals($route, true);
    }

    /**
     * Tests string regex parsing with query string
     */
    public function testStringRegexRouteWithQueryString()
    {
        $parser = new Parser('/{id}/{post}');
        $route  = $parser->parse('/1/32?test=this-is-a-test', function () {
            return true;
        });

        $this->assertEquals($route, true);
    }

    /**
     * Tests mixed regex parsing
     */
    public function testMixedRegexRouteWithQueryString()
    {
        $parser = new Parser('/{id:i}/{post:i}/{postName}');
        $route  = $parser->parse('/1/32/best-post-ever?test=this-is-a-test', function () {
            return true;
        });

        $this->assertEquals($route, true);
    }
}