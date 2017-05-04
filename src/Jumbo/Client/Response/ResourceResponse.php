<?php

namespace Jumbo\Client\Response;

use GuzzleHttp\Command\Event\ProcessEvent;
use GuzzleHttp\Command\Guzzle\Operation;
use GuzzleHttp\Message\ResponseInterface as HttpResponseInterface;

class ResourceResponse extends BaseResponse
{
    /**
     * @param Operation $operation
     * @param ProcessEvent $event
     * @return ResponseInterface
     */
    public static function fromOperation(Operation $operation, ProcessEvent $event)
    {
        return new static($event->getResponse());
    }

    /**
     * @param HttpResponseInterface $response
     */
    public function __construct(HttpResponseInterface $response)
    {
        parent::__construct($response);
    }

    /**
     * @return \Jumbo\Client\Response\Resource
     */
    public function getResource()
    {
        return new Resource($this->getData());
    }
}
