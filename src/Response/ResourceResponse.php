<?php

namespace Jumbo\Client\Response;

use GuzzleHttp\Command\Guzzle\Operation;
use GuzzleHttp\Psr7\Response as PsrResponse;
use Jumbo\Client\Response\Resource as ClientResource;

class ResourceResponse extends BaseResponse
{
    /** @var ClientResource */
    protected $resource;

    /**
     * @return ResourceResponse
     */
    public static function fromOperation(Operation $operation, PsrResponse $response): Response
    {
        return new static($response);
    }

    public function getResource(): ClientResource
    {
        if ($this->resource === null) {
            $this->resource = new Resource($this->getData());
        }

        return $this->resource;
    }
}
