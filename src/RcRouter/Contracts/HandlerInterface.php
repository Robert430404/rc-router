<?php

namespace RcRouter\Contracts;

/**
 * Interface HandlerInterface
 *
 * @package RcRouter\Contracts
 */
interface HandlerInterface
{
    /**
     * Executes the matched route
     *
     * @return mixed
     */
    public function execute();
}