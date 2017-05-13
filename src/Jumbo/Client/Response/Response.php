<?php

namespace Jumbo\Client\Response;

use GuzzleHttp\Command\Guzzle\Operation;
use GuzzleHttp\Psr7\Response as PsrResponse;

interface Response
{
    /**
     * @param Operation $operation
     * @param PsrResponse $response
     * @return Response
     */
    public static function fromOperation(Operation $operation, PsrResponse $response);

    /**
     * @return PsrResponse
     */
    public function getHttpResponse();

    /**
     * @return array
     */
    public function toArray();
}
