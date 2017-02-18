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
     * @var string
     */
    private $intRegex;

    /**
     * @var string
     */
    private $stringRegex;

    /**
     * @var string
     */
    private $intPlaceholder;

    /**
     * @var string
     */
    private $stringPlaceholder;

    /**
     * Parser constructor.
     *
     * @param string $uri
     */
    function __construct(string $uri)
    {
        $this->uri               = $uri;
        $this->intRegex          = '/\/([\-0-9]+)/';
        $this->stringRegex       = '/\/([a-zA-Z]+)/';
        $this->intPlaceholder    = '/{([A-Za-z]+:[i])}/';
        $this->stringPlaceholder = '/{([A-Za-z]+)}/';
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
    private function matchSimpleRoute(string $uri, $handler): bool
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
    private function matchQueryStringRoute(string $uri, $handler): bool
    {
        $parts = explode('?', $this->uri);

        if ($parts[0] === $uri) {
            $handler();

            return true;
        }

        return false;
    }

    /**
     * Matches Routes With Regex Placeholders
     *
     * @param string $route
     * @param $handler
     * @return bool
     */
    private function matchRegexRoute(string $route, $handler): bool
    {
        $mapped     = null;
        $routeArray = explode('/', $route);
        $uriArray   = explode('/', $this->uri);

        if (strpos($this->uri, '?') > 0) {
            $parts    = explode('?', $this->uri);
            $uriArray = explode('/', $parts[0]);
        }

        if (count($routeArray) !== count($uriArray)) {
            return false;
        }

        array_shift($routeArray);
        array_shift($uriArray);

        $mapped       = $this->mapParams($routeArray, $uriArray);
        $matchedRoute = '/' . implode('/', $mapped['all']);

        if (isset($parts)) {
            $matchedRoute = '/' . implode('/', $mapped['all']) . '?' . $parts[1];
        }

        if ($this->uri === $matchedRoute) {
            $handler($mapped);

            return true;
        }

        return false;
    }

    /**
     * Returns the matched params
     *
     * @param array $routeArray
     * @param array $uriArray
     * @return array
     */
    private function mapParams(array $routeArray, array $uriArray): array
    {
        return [
            'all'    => $this->mapAllParams($routeArray, $uriArray),
            'int'    => $this->mapIntParams($routeArray, $uriArray),
            'string' => $this->mapStringParams($routeArray, $uriArray),
        ];
    }

    /**
     * Returns all route params
     *
     * @param array $routeArray
     * @param array $uriArray
     * @return array
     */
    private function mapAllParams(array $routeArray, array $uriArray): array
    {
        $mapped = [];

        foreach ($routeArray as $key => $request) {
            $newKey = str_replace('{', '', $request);
            $newKey = str_replace(':i}', '', $newKey);
            $newKey = str_replace('}', '', $newKey);

            if (strpos($request, ':i') > 0) {
                $mapped[$newKey] = (int)$uriArray[$key];
            }

            if (!strpos($request, ':i')) {
                $mapped[$newKey] = $uriArray[$key];
            }
        }

        return $mapped;
    }

    /**
     * Returns the integer route params
     *
     * @param array $routeArray
     * @param array $uriArray
     * @return array
     */
    private function mapIntParams(array $routeArray, array $uriArray): array
    {
        $mapped = [];

        foreach ($routeArray as $key => $request) {
            if (strpos($request, ':i') > 0) {
                $newKey = str_replace('{', '', $request);
                $newKey = str_replace(':i}', '', $newKey);

                $mapped[$newKey] = (int)$uriArray[$key];
            }
        }

        return $mapped;
    }

    /**
     * Returns the string route params
     *
     * @param array $routeArray
     * @param array $uriArray
     * @return array
     */
    private function mapStringParams(array $routeArray, array $uriArray): array
    {
        $mapped = [];

        foreach ($routeArray as $key => $request) {
            if (!strpos($request, ':i') && strpos($request, '}') > 0) {
                $newKey = str_replace('{', '', $request);
                $newKey = str_replace('}', '', $newKey);

                $mapped[$newKey] = $uriArray[$key];
            }
        }

        return $mapped;
    }
}