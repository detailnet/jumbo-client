<?php

namespace Jumbo\Client\Response;

use Guzzle\Http\Message\Response as HttpResponse;
use GuzzleHttp\Command\Guzzle\Operation;

interface Response
{
    /**
     * @param Operation $operation
     * @param HttpResponse $response
     * @return Response
     */
    public static function fromOperation(Operation $operation, HttpResponse $response);

    /**
     * @return HttpResponse
     */
    public function getHttpResponse();

    /**
     * @return array
     */
    public function toArray();
}
