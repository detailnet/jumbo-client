<?php

namespace Jumbo\Client\Response;

use GuzzleHttp\Command\Guzzle\Operation;
use GuzzleHttp\Psr7\Response as PsrResponse;

interface Response
{
    public static function fromOperation(Operation $operation, PsrResponse $response): Response;

    /**
     * @param array<string, mixed> $options
     */
    public function __construct(PsrResponse $response, array $options = []);

    public function getHttpResponse(): PsrResponse;

    public function toArray(): array;
}
