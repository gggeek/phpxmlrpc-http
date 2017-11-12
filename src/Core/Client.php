<?php

namespace PhpHttpRpc\Core;

use Psr\Http\Message\RequestInterface as HttpRequestInterface;
use Psr\Http\Message\ResponseInterface as HttpResponseInterface;
use Http\Message\RequestFactory;
use Http\Client\HttpClient as HttpClientInterface;
use PhpHttpRpc\HTTP\Discovery\HttpClientDiscovery;
use PhpHttpRpc\HTTP\Discovery\MessageFactoryDiscovery;
use PhpHttpRpc\API\Client as RpcClientInterface;
use PhpHttpRpc\API\Request as RpcRequestInterface;
use PhpHttpRpc\API\Response as RpcResponseInterface;
use PhpHttpRpc\API\Exception\UnsupportedOptionException;

abstract class Client implements RpcClientInterface
{
    const USE_CURL_NEVER = 0;
    const USE_CURL_ALWAYS = 1;
    const USE_CURL_AUTO = 2;

    const RETURN_VALUE = 0;
    const RETURN_PHP = 1;
    const RETURN_RAW = 2;

    protected $options = array(
        'timeout' => null,
        'keepAlive' => true,
        'userAgent' => null,

        'username' => null,
        'password' => null,
        'authType' => null,

        'requestCompression' => null,
        'acceptedCompression' => null,
        'acceptedCharsetEncodings' => null,
        'httpVersion' => null,

        'proxyHost' => null,
        'proxyPort' => null,
        'proxyUsername' => null,
        'proxyPassword' => null,
        'proxyAuthType' => null,

        'SSLVersion' => null,
        'SSLVerifyHost' => null,
        'SSLVerifyPeer' => null,
        'SSLCert' => null,
        'SSLCertPass' => null,
        'SSLCACert' => null,
        'SSLCACertDir' => null,
        'SSLKey' => null,
        'SSLKeyPass' => null,

        'useCURL' => self::USE_CURL_AUTO,
        'returnType' => self::RETURN_VALUE,
        'debug' => null,
    );

    /** @var HttpClientInterface $httpClient */
    protected $httpClient;
    /** @var RequestFactory $requestFactory */
    protected $requestFactory;

    /**
     * Client constructor.
     * @param string $uri
     * @param array $options
     */
    public function __construct($uri, array $options = array())
    {
        if (!isset($options['httpClient'])) {
            $client = $options['httpClient'];
            unset($options['httpClient']);
        } else {
            $client = HttpClientDiscovery::find();
        }
        $this->setHTTPClient($client);

        if (!isset($options['requestFactory'])) {
            $requestFactory = $options['requestFactory'];
            unset($options['requestFactory']);
        } else {
            $requestFactory = MessageFactoryDiscovery::find();
        }
        $this->setRequestFactory($requestFactory);

        $this->setOptions($options);
    }

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
     * @throws UnsupportedOptionException if option is not supported or valid
     */
    public function setOption($option, $value)
    {
        if (!array_key_exists($option, $this->options) )
        {
            throw new UnsupportedOptionException("Option $option is not supported");
        }

        switch ($option) {
            default:
                $this->validateOption($option, $value);
                $this->options[$option] = $value;
        }
    }

    /**
     * @param string $option
     * @param mixed $value
     *
     * @throws UnsupportedOptionException if option is not valid
     */
    protected function validateOption($option, $value)
    {
        // left for subclasses to implement
    }

    /**
     * Set many options in one fell swoop
     *
     * @param array $options
     *
     * @throws UnsupportedOptionException if an option is not supported
     */
    public function setOptions(array $options)
    {
        foreach($options as $name => $value)
        {
            $this->setOption($name, $value);
        }
    }

    /**
     * Retrieves the current value for any option
     * @param string $option
     *
     * @return bool|int|string
     *
     * @throws UnsupportedOptionException if option is not supported
     */
    public function getOption($option)
    {
        if (!array_key_exists($option, $this->options) )
        {
            throw new UnsupportedOptionException("Option $option is not supported");
        }
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
        /// @todo add all our own headers
        return $headers;
    }

    protected function getHTTPRequestBody($body)
    {
        /// @todo compress if needed
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
