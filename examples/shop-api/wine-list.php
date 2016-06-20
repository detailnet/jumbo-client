<?php

use Denner\Client\ShopClient;

$config = require realpath(__DIR__ . '/../bootstrap.php');
$params = array();

// Example: ?page=2
if (isset($_GET['page'])) {
    $params['page'] = (int) $_GET['page'];
}

// Example: &page_size=20
if (isset($_GET['page_size'])) {
    $params['page_size'] = (int) $_GET['page_size'];
}

$params['sort'] = array(
    array(
        'property' => 'id',
        'direction' => 'asc',
    ),
);

$client = ShopClient::factory($config);

$response = $client->listWines($params);

var_dump($response);

// To access specific properties of a wine at any depth:
//var_dump($response->getResources()[0]->search('wine.country'));
