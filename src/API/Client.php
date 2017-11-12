<?php

namespace PhpHttpRpc\API;

interface Client
{
    /**
     * Sends a request and returns the response object.
     * Note that the client will always return a Response object, even if the call fails
     *
     * @param Request $request
     * @return Response
     */
    public function send(Request $request);

    /**
     * One-stop shop for setting all configuration options without having to write a hundred method calls
     * @param string $option
     * @param mixed $value
     *
     * @throws \PhpHttpRpc\API\Exception\UnsupportedOptionException if option is not supported
     */
    public function setOption($option, $value);

    /**
     * Set many options in one fell swoop
     *
     * @param array $options
     *
     * @throws \PhpHttpRpc\API\Exception\UnsupportedOptionException if an option is not supported
     */
    public function setOptions(array $options);

    /**
     * Retrieves the current value for any option
     * @param string $option
     *
     * @return bool|int|string
     *
     * @throws \PhpHttpRpc\API\Exception\UnsupportedOptionException if option is not supported
     */
    public function getOption($option);
}
