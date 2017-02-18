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
     *
     * @param string $uri
     * @param string $method
     */
    public function __construct(string $uri, string $method)
    {
        $this->parser = new Parser($uri);
        $this->method = $method;
    }

    /**
     * Sends GET Request To Route
     *
     * @param string $uri
     * @param $handler
     * @return void
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
     * @return void
     * @throws WrongHttpMethodException
     */
    public function post(string $uri, $handler)
    {
        if ($this->method !== 'POST') {
            throw new WrongHttpMethodException('This is not a POST request.');
        }

        if ($this->parser->parse($uri, $handler)) {
            die();
        }
    }

    /**
     * Sends PUT Request To Route
     *
     * @param string $uri
     * @param $handler
     * @return void
     * @throws WrongHttpMethodException
     */
    public function put(string $uri, $handler)
    {
        if ($this->method !== 'PUT') {
            throw new WrongHttpMethodException('This is not a PUT request.');
        }

        if ($this->parser->parse($uri, $handler)) {
            die();
        }
    }

    /**
     * Sends DELETE Request To Route
     *
     * @param string $uri
     * @param $handler
     * @return void
     * @throws WrongHttpMethodException
     */
    public function delete(string $uri, $handler)
    {
        if ($this->method !== 'DELETE') {
            throw new WrongHttpMethodException('This is not a DELETE request.');
        }

        if ($this->parser->parse($uri, $handler)) {
            die();
        }
    }

    /**
     * This handles any unregistered or not found routes.
     *
     * @param $handler
     * @return void
     */
    public function notFound($handler)
    {
        $handler(); die();
    }
}