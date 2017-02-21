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
     * @param array $methods
     * @param string $uri
     * @param callable $handler
     * @return mixed
     */
    public function request(array $methods, string $uri, Callable $handler);
}