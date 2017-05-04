<?php

namespace Jumbo\Client\Response;

use Guzzle\Http\Message\Response as HttpResponse;
use GuzzleHttp\Command\Guzzle\Operation;

class ResourceResponse extends BaseResponse
{
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
     * @return \Jumbo\Client\Response\Resource
     */
    public function getResource()
    {
        return new Resource($this->getData());
    }
}
