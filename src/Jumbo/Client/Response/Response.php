<?php

namespace Jumbo\Client\Response;

use Guzzle\Http\Message\Response as HttpResponse;
use GuzzleHttp\Command\Guzzle\Operation;
use GuzzleHttp\Command\ResultInterface;

interface Response extends ResultInterface
{
    /**
     * @param Operation $operation
     * @param HttpResponse $response
     * @return Response
     */
    public static function fromOperation(Operation $operation, HttpResponse $response);
}
