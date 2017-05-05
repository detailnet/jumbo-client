<?php

use Jumbo\Client\AssetsClient;
use Jumbo\Client\AssetUploadFromContents;

$config = require realpath(__DIR__ . '/../bootstrap.php');

$upload = new AssetUploadFromContents(
    'jumbo.png',
    'web',
    '91fa463c-a01c-45fa-b693-f8a76ffb9aa8', // Artikelbild
    file_get_contents('jumbo.png')
);
$upload->setMimeType('image/png');
$upload->setLanguages(array('de'));
//$upload->setTags(array('94656855-b318-4fb8-aa43-569b78ba22d1'));
$upload->setArticles(array(array('code' => '1197364')));

$client = AssetsClient::factory($config);
$client->setAssetTransmitter();

$asset = $client->uploadAsset($upload);

var_dump($asset);
