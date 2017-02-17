<?php

namespace RcRouter\Exceptions;

use Exception;

/**
 * Class WrongHttpMethodException
 *
 * @package RcRouter\Exceptions
 */
class WrongHttpMethodException extends Exception
{
    /**
     * @var string
     */
    private $method;

    /**
     * WrongHttpMethodException constructor.
     *
     * @param string $message
     * @param int $code
     * @param Exception|null $previous
     */
    public function __construct($message, $code = 500, Exception $previous = null)
    {
        $this->method = $_SERVER['REQUEST_METHOD'];

        parent::__construct($message, $code, $previous);
    }

    /**
     * Returns the used method when called.
     *
     * @return string
     */
    public function seeUsedMethod()
    {
        return $this->method;
    }
}