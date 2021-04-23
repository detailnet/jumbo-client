<?php

namespace Jumbo\Client\Response;

use Jumbo\Client\Response\Resource as ClientResource;
use GuzzleHttp\Command\Guzzle\Operation;
use GuzzleHttp\Psr7\Response as PsrResponse;

class ResourceResponse extends BaseResponse
{
    protected ?ClientResource $resource = null;

    /**
     * @param Operation $operation
     * @param PsrResponse $response
     * @return ResourceResponse
     */
    public static function fromOperation(Operation $operation, PsrResponse $response): Response
    {
        return new static($response);
    }

    public function getResource(): ClientResource
    {
        if ($this->resource === null) {
            $this->resource = new ClientResource($this->getData());
        }

        return $this->resource;
    }
}
