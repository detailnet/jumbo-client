<?php

namespace Jumbo\Client;

use Psr\Http\Message\RequestInterface as PsrRequest;
use Psr\Http\Message\ResponseInterface as PsrResponse;

use Guzzle\Http\Message\Response as HttpResponse;
use GuzzleHttp\Command\CommandInterface;
use GuzzleHttp\Command\Guzzle\DescriptionInterface as ServiceDescription;
use GuzzleHttp\Exception\RequestException;

use Jumbo\Client\Response\Response;

class Deserializer
{
    /**
     * @var ServiceDescription $description
     */
    protected $description;

    /**
     * Deserializer constructor.
     * @param ServiceDescription $description
     */
    public function __construct(ServiceDescription $description)
    {
        $this->description = $description;
    }

    /**
     * @param PsrResponse $response
     * @param PsrRequest|null $request
     * @param CommandInterface $command
     * @return Response
     */
    public function __invoke(PsrResponse $response, PsrRequest $request, CommandInterface $command)
    {
        if ($response->getStatusCode() >= 400) {
            throw RequestException::create($request, $response);
        }

        $httpResponse = new HttpResponse(
            $response->getStatusCode(),
            $response->getHeaders(),
            $response->getBody()
        );

        $name = $command->getName();
        $operation = $this->description->getOperation($name);

        $responseClass = $operation->getResponseModel();

        if ($responseClass === null) {
            throw new Exception\RuntimeException(
                sprintf('No response class configured for operation "%s"', $command->getName())
            );
        }

        if (!class_exists($responseClass)) {
            throw new Exception\RuntimeException(
                sprintf(
                    'Response class "%s" of operation "%s" does not exist',
                    $responseClass,
                    $command->getName()
                )
            );
        }

        /** @todo We could check if the response class implements ResponseInterface */

        /** @var Response $responseClass */

        return $responseClass::fromOperation($operation, $httpResponse);
    }
}
