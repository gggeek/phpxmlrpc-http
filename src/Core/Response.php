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
}
