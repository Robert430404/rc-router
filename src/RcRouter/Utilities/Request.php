<?php

namespace RcRouter\Utilities;

use stdClass;

/**
 * Class Request
 *
 * @package RcRouter\Utilities
 */
class Request
{
    /**
     * @var stdClass
     */
    private $get;

    /**
     * @var stdClass
     */
    private $post;

    /**
     * @var stdClass
     */
    private $route;

    /**
     * Request constructor.
     *
     * @param null $routeParams
     */
    function __construct($routeParams = null)
    {
        $this->get   = $this->buildGetParams();
        $this->post  = $this->buildPostParams();
        $this->route = new stdClass();

        if (!is_null($routeParams)) {
            $this->route = $this->buildRouteParams($routeParams);
        }
    }

    /**
     * Returns the GET parameters for use
     *
     * @return stdClass
     */
    public function getParams(): stdClass
    {
        return $this->get;
    }

    /**
     * Returns the GET parameters for use
     *
     * @return stdClass
     */
    public function postParams(): stdClass
    {
        return $this->post;
    }

    /**
     * Returns the GET parameters for use
     *
     * @return stdClass
     */
    public function routeParams(): stdClass
    {
        return $this->route;
    }

    /**
     * Builds the GET parameters
     *
     * @return stdClass
     */
    private function buildGetParams(): stdClass
    {
        $getObj = new stdClass();

        foreach ($_GET as $key => $param) {
            $getObj->$key = $param;
        }

        return $getObj;
    }

    /**
     * Builds the POST parameters
     *
     * @return stdClass
     */
    private function buildPostParams(): stdClass
    {
        $postObj = new stdClass();

        foreach ($_POST as $key => $param) {
            $postObj->$key = $param;
        }

        return $postObj;
    }

    /**
     * Builds the route parameters
     *
     * @param $params
     * @return stdClass
     */
    private function buildRouteParams($params): stdClass
    {
        $routeObj = new stdClass();

        foreach ($params as $key => $param) {
            $routeObj->$key = $param;
        }

        return $routeObj;
    }

}