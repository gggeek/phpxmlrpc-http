<?php

namespace PhpHttpRpc\Core;

use PhpHttpRpc\API\Response as RpcResponseInterface;

abstract class Response implements RpcResponseInterface
{
    protected $errNo = 0;
    protected $errStr = '';
    protected $value;

    public function faultCode()
    {
        return $this->errNo;
    }

    public function faultString()
    {
        return $this->errStr;
    }

    public function value()
    {
        return $this->value;
    }

    /**
     * Will be called when this response is serialized for sending
     *
     * @return string[][] Returns an associative array of the response's headers. Each
     *     key MUST be a header name, and each value MUST be an array of strings
     *     for that header.
     */
    abstract public function getHTTPHeaders();

    /**
     * Will be called when this response is serialized for sending
     * Q: should we return a (plain php) stream instead?
     *
     * @return string
     */
    abstract public function getHTTPBody();
}
