<?php

namespace PhpHttpRpc\HTTP\API\Exception;

/**
 * Every HTTP client related Exception MUST implement this interface.
 */
interface ClientException
{
    // same methods as in php 7 \Throwable
    public function getMessage();
    public function getCode();
    public function getFile();
    public function getLine();
    public function getTrace();
    public function getTraceAsString();
    public function getPrevious();
    public function __toString();
}
