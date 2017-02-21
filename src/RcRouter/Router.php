<?php

namespace RcRouter;

use RcRouter\Contracts\RouterInterface;

/**
 * Class Router
 *
 * @package RcRouter
 */
class Router implements RouterInterface
{
    private $requests;

    /**
     * Router constructor.
     */
    public function __construct()
    {
        $this->requests = [];
    }

    /**
     * @param array $methods
     * @param string $uri
     * @param callable $handler
     * @return mixed|void
     */
    public function request(array $methods, string $uri, Callable $handler)
    {
        array_push($this->requests, new Route($methods, $uri, $handler));
    }

    /**
     * Returns the registered routes for resolution
     *
     * @return array
     */
    public function routes(): array
    {
        return $this->requests;
    }
}