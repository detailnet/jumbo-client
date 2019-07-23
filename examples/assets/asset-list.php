<?php

use Jumbo\Client\AssetsClient;

$config = require realpath(__DIR__ . '/../bootstrap.php');
$params = [];

// Example: ?page=2
if (isset($_GET['page'])) {
    $params['page'] = (int) $_GET['page'];
}

// Example: &page_size=20
if (isset($_GET['page_size'])) {
    $params['page_size'] = (int) $_GET['page_size'];
}

//$params['filter'] = [
//    [
//        'property' => 'status',
//        'value' => 'complete',
//        'operator' => '=', // equals
//        'type' => 'string',
//    ],
//];

$params['sort'] = [
    [
        'property' => 'created_on',
        'direction' => 'desc',
    ],
];

$client = AssetsClient::factory($config);

$response = $client->listAssets($params);

var_dump($response->toArray());
