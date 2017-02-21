<?php

namespace RcRouter\Utilities;

use RcRouter\Exceptions\RouteNotFoundException;
use RcRouter\Exceptions\WrongHttpMethodException;
use RcRouter\Router;

/**
 * Class Resolver
 *
 * @package RcRouter\Utilities
 */
class Resolver
{
    /**
     * @var string
     */
    private $uri;

    /**
     * @var string
     */
    private $method;

    /**
     * @var Router
     */
    private $router;

    /**
     * @var Parser
     */
    private $parser;

    /**
     * @var bool
     */
    private $resolution;

    /**
     * Resolver constructor.
     *
     * @param string $uri
     * @param string $method
     * @param Router $router
     */
    function __construct(string $uri, string $method, Router $router)
    {
        $this->uri        = $uri;
        $this->method     = $method;
        $this->router     = $router;
        $this->resolution = false;
        $this->parser     = new Parser($this->uri);

        $this->resolve();
    }

    /**
     * Returns the status of the route
     *
     * @return bool
     */
    public function getResolution(): bool
    {
        return $this->resolution;
    }

    /**
     * Sets the status of the route
     *
     * @param bool $status
     */
    public function setResolution(bool $status)
    {
        $this->resolution = $status;
    }

    /**
     * Resolves the routes and throws an exception if there is a method mismatch
     *
     * @return void
     * @throws RouteNotFoundException
     * @throws WrongHttpMethodException
     */
    private function resolve()
    {
        $matched = 0;
        $routes  = $this->router->routes();

        foreach ($routes as $route) {
            $parsed = $this->parser->parse($route);

            if ($parsed['matched'] === true) {
                if (!in_array($this->method, $route->getMethods())) {
                    throw new WrongHttpMethodException('This Request Method Is Not Allowed');
                }

                $handler = $route->getHandler();

                $this->setResolution(true);

                if (isset($parsed['mapped'])) {
                    $handler($parsed['mapped']);
                } else {
                    $handler();
                }

                $matched++;

                break;
            }
        }

        if ($matched === 0) {
            throw new RouteNotFoundException('There are no matching routes');
        }
    }
}