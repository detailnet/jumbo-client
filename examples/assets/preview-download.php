<?php

use Jumbo\Client\AssetsClient;

$config = require realpath(__DIR__ . '/../bootstrap.php');

$assetId = @$_GET['asset_id'] ?: '44444444-aaaa-4444-aaaa-444444444444';
$expireAfter = @$_GET['expire_after'] ? (int) $_GET['expire_after'] : null;

if (!$assetId) {
    throw new RuntimeException('Missing or invalid parameter "asset_id"');
}

$client = AssetsClient::factory($config);

$url = $client->downloadPreview($assetId, $expireAfter);

var_dump($url);
