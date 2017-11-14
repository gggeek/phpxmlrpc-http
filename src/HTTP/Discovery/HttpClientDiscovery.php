<?php

namespace PhpHttpRpc\HTTP\Discovery;

use Http\Client\HttpClient;
use PhpHttpRpc\HTTP\Client;

class HttpClientDiscovery
{
    /**
     * @param array $options the returned client should be able to support all of these options and configured with them
     * @return HttpClient
     *
     * @todo make this a bit more flexible: allow the options to contain a ResponseFactory
     */
    public static function find(array $options = array())
    {
        return new Client(null, $options);
    }
}
