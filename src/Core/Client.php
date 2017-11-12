<?php

namespace PhpHttpRpc\Core;

use PhpHttpRpc\API\Client as RpcClientInterface;
use PhpHttpRpc\API\Request as RpcRequestInterface;
use PhpHttpRpc\API\Response as RpcResponseInterface;
use Psr\Http\Message\RequestInterface as HttpRequestInterface;
use Psr\Http\Message\ResponseInterface as HttpResponseInterface;
use Http\Client\HttpClient as HttpClientInterface;
use Http\Message\RequestFactory;
use PhpHttpRpc\HTTP\Discovery\HttpClientDiscovery;
use PhpHttpRpc\HTTP\Discovery\MessageFactoryDiscovery;

abstract class Client implements RpcClientInterface
{
    protected $options = array();
    /** @var HttpClientInterface $httpClient */
    protected $httpClient;
    /** @var RequestFactory $requestFactory */
    protected $requestFactory;

    /**
     * Sends a request and returns the response object.
     * Note that the client will always return a Response object, even if the call fails
     *
     * @param RpcRequestInterface $request
     * @return RpcResponseInterface
     */
    public function send(RpcRequestInterface $request)
    {
        try {
            // q: how do we pass to $this->httpClient all the info about the desired options ? HTTPlug uses plugins...
            $httpRequest = $this->buildHttpRequest($request);
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

    public function setRequestFactory(RequestFactory $requestFactory)
    {
        $this->requestFactory = $requestFactory;
    }

    public function setHTTPClient(HttpClientInterface $client)
    {
        $this->httpClient = $client;
    }

    /**
     * @param RpcRequestInterface $request
     *
     * @return HttpRequestInterface
     */
    protected function buildHttpRequest(RpcRequestInterface $request)
    {
        $httpRequest = $this->requestFactory->createRequest(
            $request->getHTTPMethod(),
            $request->withHTTPUri($this->getUri()),
            $this->getHTTPRequestHeaders($request->getHTTPHeaders()),
            $this->getHTTPRequestBody($request->getHTTPBody()),
            $this->getHTTPRequestProtocolVersion()
        );

        return $httpRequest;
    }

    protected function getUri()
    {
        /// @todo
    }

    protected function getHTTPRequestHeaders(array $headers = array())
    {
        return $headers;
    }

    protected function getHTTPRequestBody($body)
    {
        return $body;
    }

    protected function getHTTPRequestProtocolVersion()
    {
        /// @todo allow options to modify this
        return '1.1';
    }

    /**
     * @param RpcRequestInterface $request
     * @param HttpResponseInterface $response
     *
     * @return RpcResponseInterface
     */
    protected function buildRpcResponse(RpcRequestInterface $request, HttpResponseInterface $response)
    {
        $headers = $response->getHeaders();
        $body = (string)$response->getBody();
        return $request->parseHTTPResponse($body, $headers);
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
