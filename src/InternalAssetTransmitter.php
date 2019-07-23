<?php

namespace Jumbo\Client;

use GuzzleHttp\ClientInterface as HttpClient;
use Psr\Http\Message\ResponseInterface as PsrResponse;
use SimpleXMLElement;

class InternalAssetTransmitter implements
    AssetTransmitter
{
    /** @var HttpClient */
    private $client;

    public function __construct(HttpClient $client)
    {
        $this->setClient($client);
    }

    public function getClient(): HttpClient
    {
        return $this->client;
    }

    public function setClient(HttpClient $client): void
    {
        $this->client = $client;
    }

    public function upload(AssetUpload $upload): void
    {
        $client = $this->getClient();
        $response = $client->request(
            'PUT',
            $upload->getUploadUrl(),
            [
                'body' => $upload->getContents(),
                'headers' => [
                    'Content-Type' => $upload->getMimeType(),
                    'x-amz-acl' => 'private',
                    'x-amz-server-side-encryption' => 'AES256',
                ],
            ]
        );

        if ($response->getStatusCode() >= 400) {
            throw new Exception\RuntimeException(
                sprintf('Failed to upload file: %s', $this->extractErrorMessage($response))
            );
        }

        $upload->setUrl(strtok($upload->getUploadUrl(), '?'));
    }

    public function download(string $url): array
    {
        /** @todo Implement downloading */
        throw new Exception\RuntimeException('Downloading is not yet implemented');
    }

    private function extractErrorMessage(PsrResponse $response): string
    {
        $result = new SimpleXMLElement($response->getBody());

        $code = (string) $result->xpath('//Code')[0];
        $message = (string) $result->xpath('//Message')[0];

        if (!$message) {
            $message = 'Unknown error';
        }

        if ($code) {
            $message .= sprintf(' (%s)', $code);
        }

        return $message;
    }
}
