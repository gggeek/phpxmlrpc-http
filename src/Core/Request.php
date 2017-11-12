<?php

namespace PhpHttpRpc\Core;

use PhpHttpRpc\API\Request as RpcRequestInterface;

abstract class Request implements RpcRequestInterface
{
    protected $methodName;
    protected $params = array();
    protected $contentType = '';
    protected $allowedParamClass = '\PhpHttpRpc\API\Value';

    public function __construct($methodName, $params = array())
    {
        $this->methodName = $methodName;
        foreach ($params as $param) {
            $this->addParam($param);
        }
    }

    public function method($methodName = null)
    {
        if ($methodName !== null) {
            $this->methodName = $methodName;
        }

        return $this->methodName;
    }

    public function addParam($param)
    {
        if ($this->isValidParam($param)) {
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

    protected function isValidParam($param)
    {
        return ($param instanceof $this->allowedParamClass);
    }

    /**
     * The default implementation does not modify the original URI
     * @param string $uri
     * @return string
     */
    public function witHTTPhUri($uri)
    {
        return $uri;
    }

    /**
     * The default is to use POST requests
     * @return string
     */
    public function getHTTPMethod()
    {
        return 'POST';
    }

    public function getHTTPHeaders()
    {
        return array(
            'Content-Type' => array($this->contentType)
        );

        // @todo if method is POST, should we add Content-Length as well? Or leave it to the Client?
    }

    abstract public function getHTTPBody();

    abstract public function parseHTTPResponse($body, array $headers = array(), array $options = array());
}
