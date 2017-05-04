<?php

namespace Jumbo\Client\Response;

use Guzzle\Common\Exception as GuzzleException;
use Guzzle\Http\Message\Response as HttpResponse;

use Jumbo\Client\Exception;

abstract class BaseResponse implements
    Response
{
    /**
     * @var HttpResponse
     */
    protected $response;

    /**
     * @var array
     */
    protected $data;

    /**
     * @param HttpResponse $response
     */
    public function __construct(HttpResponse $response)
    {
        $this->response = $response;
        $this->data = $this->extractData();
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
        return $this->data;
    }

    /**
     * @return array
     */
    private function extractData()
    {
        try {
            $data = $this->getHttpResponse()->json();

            return is_array($data) ? $data : array();
        } catch (GuzzleException\RuntimeException $e) {
            throw new Exception\RuntimeException(
                sprintf('Failed extract data from HTTP response: %s', $e->getMessage()),
                $e->getCode(),
                $e
            );
        }
    }
}
