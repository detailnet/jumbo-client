<?php

namespace Jumbo\Client;

//use Aws\S3\S3Client;

class InternalAssetTransmitter implements
    AssetTransmitter
{
//    /**
//     * @var S3Client
//     */
//    protected $client;
//
//    /**
//     * @param S3Client $client
//     */
//    public function __construct(S3Client $client)
//    {
//        $this->setClient($client);
//    }
//
//    /**
//     * @return S3Client
//     */
//    public function getClient()
//    {
//        return $this->client;
//    }
//
//    /**
//     * @param S3Client $client
//     */
//    public function setClient($client)
//    {
//        $this->client = $client;
//    }

    /**
     * @param AssetUpload $upload
     * @return void
     */
    public function upload(AssetUpload $upload)
    {
        /** @todo Upload to S3 and populate $upload */

//        $contents = $upload->getContents();

        $url = strtok($upload->getUploadUrl(),'?');

        $upload->setUrl($url);
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
}
