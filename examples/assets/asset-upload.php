<?php

use Jumbo\Client\AssetsClient;
use Jumbo\Client\AssetUploadFromContents;
use Jumbo\Client\InternalAssetTransmitter;

$config = require realpath(__DIR__ . '/../bootstrap.php');

$upload = new AssetUploadFromContents(
    'jumbo.png',
    'web',
    '91fa463c-a01c-45fa-b693-f8a76ffb9aa8', // Artikelbild
    file_get_contents('jumbo.png')
);
$upload->setMimeType('image/png');

$client = AssetsClient::factory($config);
$client->setAssetTransmitter(new InternalAssetTransmitter());

$asset = $client->uploadAsset($upload);

var_dump($asset);
