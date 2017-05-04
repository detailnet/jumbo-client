<?php

namespace Jumbo\Client\Response;

use Guzzle\Common\Exception as GuzzleException;
use Guzzle\Http\Message\Response as HttpResponse;

use Jumbo\Client\Exception;

abstract class BaseResponse implements
    Response
{
    use HasDataTrait;

    /**
     * @var HttpResponse
     */
    protected $response;

    /**
     * @param HttpResponse $response
     */
    public function __construct(HttpResponse $response)
    {
        $this->response = $response;
    }

    /**
     * @return HttpResponse
     */
    public function getHttpResponse()
    {
        return $this->response;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return $this->getData();
    }

    /**
     * @return array
     */
    protected function getData()
    {
        try {
            $data = $this->getHttpResponse()->json() ?: array();
        } catch (GuzzleException\RuntimeException $e) {
            throw new Exception\RuntimeException(
                sprintf('Failed decode data from HTTP response: %s', $e->getMessage()),
                $e->getCode(),
                $e
            );
        }

        return $data;
    }

    /**
     * @return array
     */
    protected function getIterationData()
    {
        return $this->getData();
    }
}
