<?php

namespace PhpHttpRpc\HTTP\Core\Discovery;

use Http\Client\HttpClient;
use PhpHttpRpc\HTTP\Core\Client;

class HttpClientDiscovery
{
    /**
     * @param array $options the returned client should be able to support all of these options and be configured with them.
     *                       The value for key 'httpResponseFactory', if set, should be an \Http\Message\ResponseFactory instance
     * @return HttpClient
     *
     * @todo make this a bit more flexible
     */
    public static function find(array $options = array())
    {
        $factory = null;
        if (isset($options['httpResponseFactory'])) {
            $factory = $options['httpResponseFactory'];
        }
        return new Client($factory, $options);
    }
}
