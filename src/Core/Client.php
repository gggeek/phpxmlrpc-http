<?php

namespace PhpHttpRpc\Core;

use PhpHttpRpc\API\Client as RpcClientInterface;
use PhpHttpRpc\API\Request as RpcRequestInterface;
use PhpHttpRpc\API\Response as RpcResponseInterface;
use Psr\Http\Message\RequestInterface as HttpRequestInterface;
use Psr\Http\Message\ResponseInterface as HttpResponseInterface;
use Http\Client\HttpClient as HttpClientInterface;

abstract class Client implements RpcClientInterface
{
    /** @var  HttpClientInterface $httpClient */
    protected $httpClient;
    protected $options = array();

    /**
     * Sends a request and returns the response object.
     * Note that the client will always return a Response object, even if the call fails
     *
     * @param RpcRequestInterface $request
     * @return RpcResponseInterface
     */
    public function send(RpcRequestInterface $request)
    {
        // build http-Request from RPC-request plus internal options, send it using $this->httpClient, get http-Response,
        //  create Rpc-Resp. and handle to it http-Response for parsing
        $httpRequest = $this->buildHttpRequest($request);
        try {
            $httpResponse = $this->httpClient->sendRequest($httpRequest);
            $rpcResponse = $this->buildRpcResponse($request, $httpResponse);
            return $rpcResponse;
        } catch(\Exception $e) {
            return $this->buildErrorResponse($e);
        }
    }

    /**
     * One-stop shop for setting all configuration options without having to write a hundred method calls
     * @param string $option
     * @param mixed $value
     *
     * @throws \Exception if option is not supported
     */
    public function setOption($option, $value)
    {
        /// @todo
    }

    /**
     * Set many options in one fell swoop
     *
     * @param array $options
     *
     * @throws \Exception if an option is not supported
     */
    public function setOptions($options)
    {
        /// @todo
    }

    /**
     * Retrieves the current value for any option
     * @param string $option
     *
     * @return bool|int|string
     *
     * @throws \Exception if option is not supported
     */
    public function getOption($option)
    {
        /// @todo
    }

    /**
     * @param RpcRequestInterface $request
     *
     * @return HttpRequestInterface
     */
    protected function buildHttpRequest(RpcRequestInterface $request)
    {
        /// @todo
    }

    /**
     * @param RpcRequestInterface $request
     * @param HttpResponseInterface $response
     *
     * @return RpcResponseInterface
     */
    protected function buildRpcResponse(RpcRequestInterface $request, HttpResponseInterface $response)
    {
        /// @todo
    }

    /**
     * @param \Exception $e
     *
     * @return RpcResponseInterface
     */
    protected function buildErrorResponse(\Exception $e)
    {
        /// @todo
    }
}
