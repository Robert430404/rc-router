<?php

namespace RcRouter\Utilities;

use RcRouter\Route;

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
    private $requestUri;

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
     * @param string $requestUri
     */
    function __construct(string $requestUri)
    {
        $this->requestUri        = $requestUri;
        $this->intRegex          = '/\/([\-0-9]+)/';
        $this->stringRegex       = '/\/([a-zA-Z]+)/';
        $this->intPlaceholder    = '/{([A-Za-z]+:[i])}/';
        $this->stringPlaceholder = '/{([A-Za-z]+)}/';
    }

    /**
     * Starts Parsing Process
     *
     * @param Route $route
     * @return array
     */
    public function parse(Route $route): array
    {
        $simple      = $this->matchSimpleRoute($route);
        $queryString = $this->matchQueryStringRoute($route);
        $regex       = $this->matchRegexRoute($route);

        if ($simple['matched']) {
            return $simple;
        }

        if ($queryString['matched']) {
            return $queryString;
        }

        if ($regex['matched']) {
            return $regex;
        }

        return [
            'matched' => false,
        ];
    }

    /**
     * Matches Simple Routes
     *
     * @param Route $route
     * @return array
     */
    private function matchSimpleRoute(Route $route): array
    {
        $uri = $route->getUri();

        if ($this->requestUri === $uri) {
            return [
                'matched' => true,
            ];
        }

        return [
            'matched' => false,
        ];
    }

    /**
     * Matches Routes With Query String
     *
     * @param Route $route
     * @return array
     */
    private function matchQueryStringRoute(Route $route): array
    {
        $uri   = $route->getUri();
        $parts = explode('?', $this->requestUri);

        if ($parts[0] === $uri) {
            return [
                'matched' => true,
            ];
        }

        return [
            'matched' => false,
        ];
    }

    /**
     * Matches Routes With Regex Placeholders
     *
     * @param Route $route
     * @return array
     */
    private function matchRegexRoute(Route $route): array
    {
        $mapped          = null;
        $routeUriArray   = explode('/', $route->getUri());
        $requestUriArray = explode('/', $this->requestUri);

        if (strpos($this->requestUri, '?') > 0) {
            $parts           = explode('?', $this->requestUri);
            $requestUriArray = explode('/', $parts[0]);
        }

        if (count($routeUriArray) !== count($requestUriArray)) {
            return [
                'matched' => false,
            ];
        }

        array_shift($routeUriArray);
        array_shift($requestUriArray);

        $mapped       = $this->mapParams($routeUriArray, $requestUriArray);
        $matchedRoute = '/' . implode('/', $mapped['all']);

        if (isset($parts)) {
            $matchedRoute = '/' . implode('/', $mapped['all']) . '?' . $parts[1];
        }

        if ($this->requestUri === $matchedRoute) {
            return [
                'matched' => true,
                'mapped'  => $mapped,
            ];
        }

        return [
            'matched' => false,
        ];
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
                $mapped[$newKey] = $uriArray[$key];
            }

            if (strpos($request, ':i') === false) {
                $mapped[$newKey] = $uriArray[$key];
            }

            if (strpos($request, '{') === false) {
                $mapped[$newKey] = $request;
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
                $newKey          = str_replace('{', '', $request);
                $newKey          = str_replace(':i}', '', $newKey);
                $mapped[$newKey] = $uriArray[$key];

                if (strpos($request, '{') === false) {
                    $mapped[$newKey] = $request;
                }
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
            if (strpos($request, ':i') === false && strpos($request, '}') > 0) {
                $newKey          = str_replace('{', '', $request);
                $newKey          = str_replace('}', '', $newKey);
                $mapped[$newKey] = $uriArray[$key];

                if (strpos($request, '{') === false) {
                    $mapped[$newKey] = $request;
                }
            }
        }

        return $mapped;
    }
}