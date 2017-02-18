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
        $parser = new Parser('/?test=this-test-is-awesome');
        $route  = $parser->parse('/', function () {
            return true;
        });

        $this->assertEquals($route, true);
    }

    /**
     * Tests integer regex parsing
     */
    public function testIntegerRegexRoute()
    {
        $parser = new Parser('/1/32');
        $route  = $parser->parse('/{id:i}/{post:i}', function ($mapped) {
            $this->assertEquals($mapped['int']['id'], 1);
            $this->assertEquals($mapped['int']['post'], 32);

            return true;
        });

        $this->assertEquals($route, true);
    }

    /**
     * Tests string regex parsing
     */
    public function testStringRegexRoute()
    {
        $parser = new Parser('/help/me');
        $route  = $parser->parse('/{first}/{second}', function ($mapped) {
            $this->assertEquals($mapped['string']['first'], 'help');
            $this->assertEquals($mapped['string']['second'], 'me');

            return true;
        });

        $this->assertEquals($route, true);
    }

    /**
     * Tests mixed regex parsing
     */
    public function testMixedRegexRoute()
    {
        $parser = new Parser('/1/32/best-post-ever');
        $route  = $parser->parse('/{id:i}/{post:i}/{postName}', function ($mapped) {
            $this->assertEquals($mapped['int']['id'], 1);
            $this->assertEquals($mapped['int']['post'], 32);
            $this->assertEquals($mapped['string']['postName'], 'best-post-ever');

            return true;
        });

        $this->assertEquals($route, true);
    }

    /**
     * Tests integer regex parsing with query string
     */
    public function testIntegerRegexRouteWithQueryString()
    {
        $parser = new Parser('/1/32?test=this-is-a-test');
        $route  = $parser->parse('/{id:i}/{post:i}', function ($mapped) {
            $this->assertEquals($mapped['int']['id'], 1);
            $this->assertEquals($mapped['int']['post'], 32);

            return true;
        });

        $this->assertEquals($route, true);
    }

    /**
     * Tests string regex parsing with query string
     */
    public function testStringRegexRouteWithQueryString()
    {
        $parser = new Parser('/robert/developer?test=this-is-a-test');
        $route  = $parser->parse('/{name}/{position}', function ($mapped) {
            $this->assertEquals($mapped['string']['name'], 'robert');
            $this->assertEquals($mapped['string']['position'], 'developer');

            return true;
        });

        $this->assertEquals($route, true);
    }

    /**
     * Tests mixed regex parsing
     */
    public function testMixedRegexRouteWithQueryString()
    {
        $parser = new Parser('/1/32/best-post-ever?test=this-is-a-test');
        $route  = $parser->parse('/{id:i}/{post:i}/{postName}', function ($mapped) {
            $this->assertEquals($mapped['int']['id'], 1);
            $this->assertEquals($mapped['int']['post'], 32);
            $this->assertEquals($mapped['string']['postName'], 'best-post-ever');

            return true;
        });

        $this->assertEquals($route, true);
    }

    /**
     * Tests to make sure the parser fails out if nothing matches
     */
    public function testRegexRouteMismatch()
    {
        $parser = new Parser('/1');
        $route  = $parser->parse('/{id:i}/{postName}', function () {
            return true;
        });

        $this->assertEquals($route, false);
    }
}