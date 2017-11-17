<?php

namespace PhpHttpRpc\HTTP\Core\Exception;

use Psr\Http\Message\RequestInterface;
use PhpHttpRpc\HTTP\API\Exception\NetworkException as NetworkExceptionInterface;

/**
 * Thrown when the request cannot be completed because of network issues.
 *
 * There is no response object as this exception is thrown when no response has been received.
 *
 * Example: the target host name can not be resolved or the connection failed.
 *
 * @todo implement the corresponding HTTP-Client exception interface when it will exist (and we move to php7 as requirement)
 */
class NetworkException extends \Exception implements NetworkExceptionInterface
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
}
