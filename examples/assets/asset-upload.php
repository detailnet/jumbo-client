<?php

use Jumbo\Client\AssetsClient;

$config = require realpath(__DIR__ . '/../bootstrap.php');

$upload = new AssetContentUpload(file_get_contents('jumbo.png'), 'jumbo.png', 'image/png');

$client = AssetsClient::factory($config);

$asset = $client->uploadAsset($upload);

var_dump($asset);
