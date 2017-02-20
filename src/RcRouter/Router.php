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
     * @return bool
     * @throws WrongHttpMethodException
     */
    public function get(string $uri, $handler): bool
    {
        if ($this->method !== 'GET') {
            throw new WrongHttpMethodException('This is not a GET request.');
        }

        return $this->parser->parse($uri, $handler);
    }

    /**
     * Sends POST Request To Route
     *
     * @param string $uri
     * @param $handler
     * @return bool
     * @throws WrongHttpMethodException
     */
    public function post(string $uri, $handler): bool
    {
        if ($this->method !== 'POST') {
            throw new WrongHttpMethodException('This is not a POST request.');
        }

        return $this->parser->parse($uri, $handler);
    }

    /**
     * Sends PUT Request To Route
     *
     * @param string $uri
     * @param $handler
     * @return bool
     * @throws WrongHttpMethodException
     */
    public function put(string $uri, $handler): bool
    {
        if ($this->method !== 'PUT') {
            throw new WrongHttpMethodException('This is not a PUT request.');
        }

        return $this->parser->parse($uri, $handler);
    }

    /**
     * Sends DELETE Request To Route
     *
     * @param string $uri
     * @param $handler
     * @return bool
     * @throws WrongHttpMethodException
     */
    public function delete(string $uri, $handler): bool
    {
        if ($this->method !== 'DELETE') {
            throw new WrongHttpMethodException('This is not a DELETE request.');
        }

        return $this->parser->parse($uri, $handler);
    }

    /**
     * This handles any unregistered or not found routes.
     *
     * @param $handler
     * @return void
     */
    public function notFound($handler)
    {
        $handler();
    }
}