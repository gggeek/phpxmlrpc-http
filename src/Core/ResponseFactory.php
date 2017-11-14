<?php

namespace PhpHttpRpc\Core;

use PhpHttpRpc\API\ResponseFactory as ResponseFactoryInterface;

/// Q: what if we implement this directly in the Request class ?
abstract class ResponseFactory implements ResponseFactoryInterface
{
    abstract public function parseHTTPResponse($request, $body, array $headers = array(), array $options = array());
}
