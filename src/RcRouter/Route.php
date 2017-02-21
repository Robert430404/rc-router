<?php

namespace RcRouter;

/**
 * Class Route
 *
 * @package RcRouter
 */
class Route
{
    /**
     * @var string
     */
    private $uri;

    /**
     * @var array
     */
    private $methods;

    /**
     * @var callable
     */
    private $handler;

    private $data;

    /**
     * Route constructor.
     *
     * @param array $methods
     * @param string $uri
     * @param callable $handler
     */
    function __construct(array $methods, string $uri, Callable $handler)
    {
        $this->uri     = $uri;
        $this->methods = $methods;
        $this->handler = $handler;
        $this->data    = null;
    }

    /**
     * Returns the uri for the route
     *
     * @return string
     */
    public function getUri(): string
    {
        return $this->uri;
    }

    /**
     * Returns the methods for the route
     *
     * @return array
     */
    public function getMethods(): array
    {
        return $this->methods;
    }

    /**
     * Returns the handler for the route
     *
     * @return Callable
     */
    public function getHandler(): Callable
    {
        return $this->handler;
    }

    /**
     * Returns the handler for the route
     *
     * @return null|array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Sets the mapped data for the routes
     *
     * @param $data
     */
    public function setData($data)
    {
        $this->data = $data;
    }
}