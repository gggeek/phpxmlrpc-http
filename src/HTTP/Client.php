<?php

namespace PhpHttpRpc\HTTP;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Http\Client\HttpClient;
use Http\Message\ResponseFactory;
use PhpHttpRpc\HTTP\Discovery\MessageFactoryDiscovery;

class Client implements HttpClient
{
    /** @var ResponseFactory $responseFactory */
    protected $responseFactory;

    /**
     * @param ResponseFactory|null $responseFactory to create PSR-7 responses.
     * @param array $options
     */
    public function __construct(ResponseFactory $responseFactory = null, array $options = array())
    {
        $this->responseFactory = $responseFactory ?: MessageFactoryDiscovery::find();
    }

    public function setResponseFactory(ResponseFactory $responseFactory)
    {
        $this->responseFactory = $responseFactory;
    }

    /**
     * Sends a PSR-7 request.
     *
     * @param RequestInterface $request
     *
     * @return ResponseInterface
     *
     * @throws \Http\Client\Exception If an error happens during processing the request.
     * @throws \Exception             If processing the request is impossible (eg. bad configuration).
     */
    public function sendRequest(RequestInterface $request)
    {
        /// @todo

        /*$response = $this->responseFactory->createResponse(
            $statusCode,
            $reasonPhrase,
            $headers,
            $body,
            $protocolVersion
        );
        return $response;*/
    }
}
