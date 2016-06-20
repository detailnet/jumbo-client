<?php

use Denner\Client\ShopClient;

$config = require realpath(__DIR__ . '/../bootstrap.php');

$wineId = @$_GET['wine_id'] ?: '44444444-aaaa-4444-aaaa-444444444444';

if (!$wineId) {
    throw new RuntimeException('Missing or invalid parameter "wine_id"');
}

$params = array(
    'wine_id' => $wineId,
);

// Example: ?page=2
if (isset($_GET['page'])) {
    $params['page'] = (int) $_GET['page'];
}

// Example: &page_size=20
if (isset($_GET['page_size'])) {
    $params['page_size'] = (int) $_GET['page_size'];
}

$params['sort'] = @$_GET['sort'] ?: 'created_on__desc';

$client = ShopClient::factory($config);

$response = $client->listWineAppraisals($params);

var_dump($response);
