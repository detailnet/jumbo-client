<?php

namespace Jumbo\Client;

use SimpleXMLElement;

use Psr\Http\Message\ResponseInterface as PsrResponse;

use GuzzleHttp\ClientInterface as HttpClient;

class InternalAssetTransmitter implements
    AssetTransmitter
{
    /**
     * @var HttpClient
     */
    protected $client;

    /**
     * InternalAssetTransmitter constructor.
     * @param HttpClient $client
     */
    public function __construct(HttpClient $client)
    {
        $this->setClient($client);
    }

    /**
     * @return HttpClient
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * @param HttpClient $client
     */
    public function setClient(HttpClient $client)
    {
        $this->client = $client;
    }

    /**
     * @param AssetUpload $upload
     * @return void
     */
    public function upload(AssetUpload $upload)
    {
        $client = $this->getClient();
        $response = $client->request(
            'PUT',
            $upload->getUploadUrl(),
            array(
                'body' => $upload->getContents(),
                'headers' => array(
                    'Content-Type' => $upload->getMimeType(),
                    'x-amz-acl' => 'private',
                    'x-amz-server-side-encryption' => 'AES256',
                ),
            )
        );

        if ($response->getStatusCode() >= 400) {
            throw new Exception\RuntimeException(
                sprintf('Failed to upload file: %s', $this->extractErrorMessage($response))
            );
        }

        $upload->setUrl(strtok($upload->getUploadUrl(),'?'));
    }

    /**
     * @param string $url
     * @return array
     */
    public function download($url)
    {
        /** @todo Implement downloading */
        throw new Exception\RuntimeException('Downloading is not yet implemented');
    }

    /**
     * @param PsrResponse $response
     * @return string
     */
    private function extractErrorMessage(PsrResponse $response)
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
