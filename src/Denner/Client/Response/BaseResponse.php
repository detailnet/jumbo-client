<?php

namespace Denner\Client\Response;

use GuzzleHttp\Message\ResponseInterface as HttpResponseInterface;

abstract class BaseResponse implements
    \ArrayAccess,
    \Countable,
    \IteratorAggregate
{
    /**
     * @var HttpResponseInterface
     */
    protected $httpResponse;

    /**
     * @param HttpResponseInterface $response
     */
    public function __construct(HttpResponseInterface $response)
    {
        $this->httpResponse = $response;
    }

    /**
     * @return HttpResponseInterface
     */
    public function getHttpResponse()
    {
        return $this->httpResponse;
    }

    /**
     * @return array
     */
    protected function getData()
    {
        $data = $this->getHttpResponse()->json() ?: array();

        return $data;
    }
}
