<?php

namespace PhpHttpRpc\API;

interface Request
{
    /**
     * @param string $methodName the name of the method to invoke
     * @param Value[] $params array of parameters to be passed to the method (NB: Value objects, not plain php values)
     */
    public function __construct($methodName, $params = array());

    /**
     * Gets/sets the method to be invoked.
     *
     * @param string $methodName the method to be set (leave empty not to set it)
     *
     * @return string the method that will be invoked
     */
    public function method($methodName = null);

    /**
     * Adds a parameter to the list of parameters to be used upon method invocation.
     *
     * Checks that $params is actually a Value object and not a plain php value.
     *
     * @param Value $param
     *
     * @return boolean false on failure
     *
     * @todo this should throw if received value is not compatible, but that is an API breackage for phpxmlrpc...
     */
    public function addParam($param);

    /**
     * Returns the nth parameter in the request. The index zero-based.
     *
     * @param integer $i the index of the parameter to fetch (zero based)
     *
     * @return Value the i-th parameter.
     *
     * @todo this should throw if received index is not compatible, but that is an API breackage for phpxmlrpc
     */
    public function getParam($i);

    /**
     * Returns all the parameters in the request.
     *
     * @return Value[] keys are integers, starting at 0
     */
    public function getParams();

    /**
     * Returns the number of parameters in the message.
     *
     * @return integer the number of parameters currently set
     */
    public function getNumParams();

    /**
     * Retrieves the method of the HTTP request.
     * Will be called when this request is serialized for sending
     *
     * @return string Returns the request method.
     */
    public function getHTTPMethod();

    /**
     * Generates the URI of the HTTP request, starting from the injected one.
     * Will be called when this request is serialized for sending
     * Q: should we use UriInterface instead?
     *
     * @param string $uri
     *
     * @return string
     */
    public function withHTTPUri($uri);

    /**
     * Generates the headers of the HTTP request.
     * Will be called when this request is serialized for sending
     *
     * @return string[][] Returns an associative array of the request's headers. Each
     *     key MUST be a header name, and each value MUST be an array of strings
     *     for that header.
     */
    public function getHTTPHeaders();

    /**
     * Generates the body of the HTTP request.
     * Will be called when this request is serialized for sending
     * Q: should we return a (plain php) stream instead?
     *
     * @return string
     */
    public function getHTTPBody();

    /**
     * @param string $body
     * @param array $headers
     * @param array $options
     * @return Response
     */
    public function parseHTTPResponse($body, array $headers = array(), array $options = array());
}
