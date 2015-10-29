<?php

use Denner\Client\ArticlesClient;

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

// Access the listings items
$response->getResources();

// Get item count
$response->getResourceCount();

// or just
$response->count();

// When the listing has multiple pages:
// Get total item count
$response->getTotalResourceCount();

// Get page count
$response->getPageCount();

// Raw response data
$response->toArray();

// Iterating the list directly

foreach ($response as $promotion) {
    // Accessing a property in Array notation
    $promotion['id'];

    // Or use accessors
    if ($promotion->has('week')) {
        $promotion->get('week');
    }

    // For more complex access to hierarchical data use JMESPath
    $promotion->search('week.number');
}
