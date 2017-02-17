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
     */
    function __construct()
    {
        $this->uri               = $_SERVER['REQUEST_URI'];
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
            $handler(new Request());

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
        $matches      = null;
        $requestArray = explode('/', $route);
        $matchArray   = explode('/', $this->uri);

        if (count($requestArray) === count($matchArray)) {
            array_shift($requestArray);
            array_shift($matchArray);

            $matches = $this->matchParams($requestArray, $matchArray);
        }

        $matchedRoute = '/' . implode('/', $matches['all']);

        if ($this->uri === $matchedRoute) {
            $handler(new Request($matches));

            return true;
        }

        return false;
    }

    /**
     * Returns the matched params
     *
     * @param array $requestArray
     * @param array $matchArray
     * @return array
     */
    private function matchParams(array $requestArray, array $matchArray): array
    {
        return [
            'all'    => $this->matchAll($requestArray, $matchArray),
            'int'    => $this->matchIntegers($requestArray, $matchArray),
            'string' => $this->matchStrings($requestArray, $matchArray),
        ];
    }

    /**
     * Returns all route params
     *
     * @param array $requestArray
     * @param array $matchArray
     * @return array
     */
    private function matchAll(array $requestArray, array $matchArray): array
    {
        $mapped = [];

        foreach ($requestArray as $key => $request) {
            $newKey = str_replace('{', '', $request);
            $newKey = str_replace(':i}', '', $newKey);
            $newKey = str_replace('}', '', $newKey);

            if (strpos($request, ':i') > 0) {
                $mapped[$newKey] = (int)$matchArray[$key];
            }

            if (!strpos($request, ':i')) {
                $mapped[$newKey] = $matchArray[$key];
            }
        }

        return $mapped;
    }

    /**
     * Returns the integer route params
     *
     * @param $requestArray
     * @param $matchArray
     * @return array
     */
    private function matchIntegers(array $requestArray, array $matchArray): array
    {
        $mapped = [];

        foreach ($requestArray as $key => $request) {
            if (strpos($request, ':i') > 0) {
                $newKey = str_replace('{', '', $request);
                $newKey = str_replace(':i}', '', $newKey);

                $mapped[$newKey] = (int)$matchArray[$key];
            }
        }

        return $mapped;
    }

    /**
     * Returns the string route params
     *
     * @param $requestArray
     * @param $matchArray
     * @return array
     */
    private function matchStrings(array $requestArray, array $matchArray): array
    {
        $mapped = [];

        foreach ($requestArray as $key => $request) {
            if (!strpos($request, ':i') && strpos($request, '}') > 0) {
                $newKey = str_replace('{', '', $request);
                $newKey = str_replace('}', '', $newKey);

                $mapped[$newKey] = $matchArray[$key];
            }
        }

        return $mapped;
    }
}