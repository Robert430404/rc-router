<?php

namespace RcRouter;

use RcRouter\Contracts\RouterInterface;
use RcRouter\Exceptions\WrongHttpMethodException;
use RcRouter\Utilities\Parser;

/**
 * Class Router
 *
 * @package RcRouter
 */
class Router implements RouterInterface
{
    /**
     * @var Parser
     */
    private $parser;

    /**
     * @var string
     */
    private $method;

    /**
     * Router constructor.
     */
    public function __construct()
    {
        $this->parser = new Parser();
        $this->method = $_SERVER['REQUEST_METHOD'];
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

        if ($this->parser->parse($uri, $handler)) {
            die();
        }
    }

    /**
     * Sends POST Request To Route
     *
     * @param string $uri
     * @param $handler
     * @return mixed|void
     * @throws WrongHttpMethodException
     */
    public function post(string $uri, $handler)
    {
        if ($this->method !== 'POST') {
            throw new WrongHttpMethodException('This is not a POST request.');
        }

        if ($uri === $this->uri) {
            $handler();
            die();
        }
    }

    /**
     * Sends PUT Request To Route
     *
     * @param string $uri
     * @param $handler
     * @return mixed|void
     * @throws WrongHttpMethodException
     */
    public function put(string $uri, $handler)
    {
        if ($this->method !== 'PUT') {
            throw new WrongHttpMethodException('This is not a PUT request.');
        }

        if ($uri === $this->uri) {
            $handler();
            die();
        }
    }

    /**
     * Sends DELETE Request To Route
     *
     * @param string $uri
     * @param $handler
     * @return mixed|void
     * @throws WrongHttpMethodException
     */
    public function delete(string $uri, $handler)
    {
        if ($this->method !== 'DELETE') {
            throw new WrongHttpMethodException('This is not a DELETE request.');
        }

        if ($uri === $this->uri) {
            $handler();
            die();
        }
    }
}