<?php

namespace Jumbo\Client\Response;

use GuzzleHttp\Command\Guzzle\Operation;
use GuzzleHttp\Psr7\Response as PsrResponse;

class ResourceResponse extends BaseResponse
{
    /**
     * @var \Jumbo\Client\Response\Resource
     */
    protected $resource;

    /**
     * @param Operation $operation
     * @param PsrResponse $response
     * @return ResourceResponse
     */
    public static function fromOperation(Operation $operation, PsrResponse $response)
    {
        return new static($response);
    }

    /**
     * @return \Jumbo\Client\Response\Resource
     */
    public function getResource()
    {
        if ($this->resource === null) {
            $this->resource = new Resource($this->getData());
        }

        return $this->resource;
    }
}
