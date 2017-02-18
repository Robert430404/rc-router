<?php

namespace RcRouter\Contracts;

/**
 * Interface RouterInterface
 *
 * @package RcRouter\Contracts
 */
interface RouterInterface
{
    /**
     * Sends GET Request To Route
     *
     * @param string $uri
     * @param $handler
     * @return mixed
     */
    public function get(string $uri, $handler);

    /**
     * Sends POST Request To Route
     *
     * @param string $uri
     * @param $handler
     * @return mixed
     */
    public function post(string $uri, $handler);

    /**
     * Sends PUT Request To Route
     *
     * @param string $uri
     * @param $handler
     * @return mixed
     */
    public function put(string $uri, $handler);

    /**
     * Sends DELETE Request To Route
     *
     * @param string $uri
     * @param $handler
     * @return mixed
     */
    public function delete(string $uri, $handler);

    /**
     * This handles any unregistered or not found routes.
     *
     * @param $handler
     * @return mixed
     */
    public function notFound($handler);
}