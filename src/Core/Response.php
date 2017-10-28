<?php

namespace PhpHttpRpc\Core;

use PhpHttpRpc\API\Response as ResponseInterface;

abstract class Response implements ResponseInterface
{
    protected $errno = 0;
    protected $errstr = '';
    protected $val;

    public function faultCode()
    {
        return $this->errno;
    }

    public function faultString()
    {
        return $this->errstr;
    }

    public function value()
    {
        return $this->val;
    }
}
