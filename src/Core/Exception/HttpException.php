<?php

namespace PhpHttpRpc\HTTP\Core\Exception;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use PhpHttpRpc\HTTP\API\Exception\HttpException as HttpExceptionInterface;

/**
 * Thrown when a response was received but the request itself failed.
 *
 * This exception MAY be thrown on HTTP response codes 4xx and 5xx.
 * This exception MUST NOT be thrown when using the client's default configuration.
 */
class HttpException extends \Exception implements HttpExceptionInterface
{
    /**
     * Returns the request.
     *
     * The request object MAY be a different object from the one passed to HttpClient::sendRequest()
     *
     * @return RequestInterface
     */
    public function getRequest()
    {
        /// @todo
    }

    /**
     * Returns the response.
     *
     * @return ResponseInterface
     */
    public function getResponse()
    {
        /// @todo
    }
}