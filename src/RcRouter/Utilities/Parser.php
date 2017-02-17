<?php

namespace RcRouter\Utilities;

/**
 * Class Parser
 *
 * @package RcRouter\Utilities
 */
class Parser
{
    /**
     * @var string
     */
    private $uri;

    /**
     * Parser constructor.
     */
    function __construct()
    {
        $this->uri = $_SERVER['REQUEST_URI'];
    }

    /**
     * Starts Parsing Process
     *
     * @param string $uri
     * @param $handler
     * @return bool
     */
    public function parse(string $uri, $handler): bool
    {
        if ($this->matchSimpleRoute($uri, $handler)) {
            return true;
        }

        if ($this->matchQueryStringRoute($uri, $handler)) {
            return true;
        }

        if ($this->matchRegexRoute($uri, $handler)) {
            return true;
        }

        return false;
    }

    /**
     * Matches Simple Routes
     *
     * @param string $uri
     * @param $handler
     * @return bool
     */
    private function matchSimpleRoute(string $uri, $handler)
    {
        if ($this->uri === $uri) {
            $handler();

            return true;
        }

        return false;
    }

    /**
     * Matches Routes With Query String
     *
     * @param string $uri
     * @param $handler
     * @return bool
     */
    private function matchQueryStringRoute(string $uri, $handler)
    {
        $parts = explode('?', $this->uri);

        if ($parts[0] === $uri) {
            $handler(new Request());

            return true;
        }

        return false;
    }

    /**
     * Matches Routes With Regex Placeholders
     *
     * @param string $uri
     * @param $handler
     * @return bool
     */
    private function matchRegexRoute(string $uri, $handler)
    {
        if ($this->uri === $uri) {
            $handler($_GET);

            return true;
        }

        return false;
    }
}