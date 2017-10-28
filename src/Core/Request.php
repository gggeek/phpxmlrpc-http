<?php

namespace PhpHttpRpc\Core;

use PhpHttpRpc\API\Value;
use PhpHttpRpc\API\Request as RequestInterface;

abstract class Request implements RequestInterface
{
    protected $methodname;
    protected $params = array();

    public function __construct($methodName, $params = array())
    {
        $this->methodname = $methodName;
        foreach ($params as $param) {
            $this->addParam($param);
        }
    }

    public function method($methodName = '')
    {
        if ($methodName != '') {
            $this->methodname = $methodName;
        }

        return $this->methodname;
    }

    public function addParam($param)
    {
        if (is_object($param) && $param instanceof Value) {
            $this->params[] = $param;

            return true;
        } else {
            return false;
        }
    }

    public function getParam($i)
    {
        return $this->params[$i];
    }

    public function getParams()
    {
        return $this->params;
    }

    public function getNumParams()
    {
        return count($this->params);
    }
}
