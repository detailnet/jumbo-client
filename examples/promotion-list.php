<?php

use Denner\Client\ArticlesClient;

$config = require 'bootstrap.php';
$params = array();

// Example: ?page=2
if (isset($_GET['page'])) {
    $params['page'] = (int) $_GET['page'];
}

// Example: &page_size=20
if (isset($_GET['page_size'])) {
    $params['page_size'] = (int) $_GET['page_size'];
}

$params['filter'] = array(
    array(
        'property' => 'year',
        'value' => '2015',
        'operator' => '=', // equals
        'type' => 'string',
    ),
    array(
        'property' => 'week',
        'value' => '50',
        'operator' => '=', // equals
        'type' => 'string',
    ),
);

$params['sort'] = array(
    array(
        'property' => 'starts_on',
        'direction' => 'desc',
    ),
);

$client = ArticlesClient::factory($config);

$response = $client->listPromotions($params);

var_dump($response);
