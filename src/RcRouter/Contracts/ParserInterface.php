<?php

namespace RcRouter\Contracts;

use RcRouter\Route;

/**
 * Interface ParserInterface
 *
 * @package RcRouter\Contracts
 */
interface ParserInterface
{
    /**
     * Parses your routes in order to match them
     *
     * This can be used to define a custom parser that extends off of the
     * base class so you can implement things like Controller#Action handling.
     *
     * @param Route $route
     * @return mixed
     */
    public function parse(Route $route);

    /**
     * Sets the URI to be parsed
     *
     * This method passes in the URI via the resolver for resolution and to return
     * the action to be used.
     *
     * @param string $uri
     * @return mixed
     */
    public function setUri(string $uri);
}