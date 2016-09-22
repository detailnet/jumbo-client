<?php

use Denner\Client\AdvertisingClient;

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

//$params['filter'] = array(
//    array(
//        'property' => 'year',
//        'value' => '2015',
//        'operator' => '=', // equals
//        'type' => 'string',
//    ),
//    array(
//        'property' => 'week',
//        'value' => '50',
//        'operator' => '=', // equals
//        'type' => 'string',
//    ),
//);
//
//$params['sort'] = array(
//    array(
//        'property' => 'article_id',
//        'direction' => 'desc',
//    ),
//);

$client = AdvertisingClient::factory($config);

$response = $client->listPrintPublications($params);

var_dump($response->getResources());
