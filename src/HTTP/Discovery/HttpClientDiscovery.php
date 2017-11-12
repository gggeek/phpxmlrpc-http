<?php

namespace PhpHttpRpc\HTTP\Discovery;

use Http\Client\HttpClient;
use PhpHttpRpc\HTTP\Client;

class HttpClientDiscovery
{
    /**
     * @return HttpClient
     * @todo make this a bit more flexible
     */
    public static function find()
    {
        return new Client();
    }
}
