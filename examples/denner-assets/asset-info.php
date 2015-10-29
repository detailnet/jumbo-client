<?php

use Denner\Client\AssetsClient;

$config = require realpath(__DIR__ . '/../bootstrap.php');

$assetId = @$_GET['asset_id'] ?: '44444444-aaaa-4444-aaaa-444444444444';

if (!$assetId) {
    throw new RuntimeException('Missing or invalid parameter "asset_id"');
}

$client = AssetsClient::factory($config);

$response = $client->fetchAsset(array('asset_id' => $assetId));

var_dump($response);
