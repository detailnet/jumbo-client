<?php

namespace Denner\Client\Response;

use ArrayIterator;

use GuzzleHttp\Command\Event\ProcessEvent;
use GuzzleHttp\Command\Guzzle\Operation;
use GuzzleHttp\Message\ResponseInterface as HttpResponseInterface;

interface ResponseInterface
{
    /**
     * @param Operation $operation
     * @param ProcessEvent $event
     * @return ResponseInterface
     */
    public static function fromOperation(Operation $operation, ProcessEvent $event);

    /**
     * @return HttpResponseInterface
     */
    public function getHttpResponse();

    /**
     * @return ArrayIterator
     */
    public function getIterator();

    /**
     * @return integer
     */
    public function count();

    /**
     * @return array
     */
    public function toArray();
}
