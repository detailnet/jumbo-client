<?php

namespace Jumbo\Client\Response;

use GuzzleHttp\Message\ResponseInterface as HttpResponseInterface;
use GuzzleHttp\Exception as GuzzleHttpException;

use Jumbo\Client\Exception;

abstract class BaseResponse implements
    ResponseInterface,
    \ArrayAccess,
    \Countable,
    \IteratorAggregate
{
    use HasDataTrait;

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
        } catch (GuzzleHttpException\ParseException $e) {
            throw new Exception\RuntimeException(
                sprintf('Parse exception requesting \'%s\'', $e->getResponse()->getEffectiveUrl()),
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
