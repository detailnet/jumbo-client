<?php

namespace Jumbo\Client;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Command\Guzzle\DescriptionInterface;
use GuzzleHttp\HandlerStack;

/**
 * This interface is to to enforce the constructor signature and a safe call of new static(...) on class extensions
 * ref: https://phpstan.org/blog/solving-phpstan-error-unsafe-usage-of-new-static
 */
interface Client
{
    public function __construct(
        ClientInterface $client,
        DescriptionInterface $description,
        callable $commandToRequestTransformer = null,
        callable $responseToResultTransformer = null,
        HandlerStack $commandHandlerStack = null,
        array $config = []
    );
}
