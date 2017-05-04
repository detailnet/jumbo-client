<?php

namespace Jumbo\Client\Response;

use Guzzle\Http\Message\Response as HttpResponse;
use GuzzleHttp\Command\Guzzle\Operation;

class ResourceResponse extends BaseResponse
{
    /**
     * @var \Jumbo\Client\Response\Resource
     */
    protected $resource;

    /**
     * @param Operation $operation
     * @param HttpResponse $response
     * @return ResourceResponse
     */
    public static function fromOperation(Operation $operation, HttpResponse $response)
    {
        return new static($response);
    }

    /**
     * @param HttpResponse $response
     */
    public function __construct(HttpResponse $response)
    {
        parent::__construct($response);

        $this->resource = new Resource($this->getData());
    }

    /**
     * @return \Jumbo\Client\Response\Resource
     */
    public function getResource()
    {
        return $this->resource;
    }
}
