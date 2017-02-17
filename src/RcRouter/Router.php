<?php

namespace RcRouter;

use RcRouter\Contracts\RouterInterface;
use RcRouter\Exceptions\WrongHttpMethodException;

/**
 * Class Router
 *
 * @package RcRouter
 */
class Router implements RouterInterface
{
    private $method;
    private $uri;

    /**
     * Router constructor.
     */
    public function __construct()
    {
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->uri    = $_SERVER['REQUEST_URI'];
    }

    /**
     * Sends GET Request To Route
     *
     * @param string $uri
     * @param $handler
     * @return mixed|void
     * @throws WrongHttpMethodException
     */
    public function get(string $uri, $handler)
    {
        if ($this->method !== 'GET') {
            throw new WrongHttpMethodException('This is not a GET request.');
        }
    }

    /**
     * Sends POST Request To Route
     *
     * @param string $uri
     * @param $handler
     * @return mixed|void
     */
    public function post(string $uri, $handler)
    {

    }

    /**
     * Sends PUT Request To Route
     *
     * @param string $uri
     * @param $handler
     * @return mixed|void
     */
    public function put(string $uri, $handler)
    {

    }

    /**
     * Sends DELETE Request To Route
     *
     * @param string $uri
     * @param $handler
     * @return mixed|void
     */
    public function delete(string $uri, $handler)
    {

    }
}