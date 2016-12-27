<!doctype html>
<html lang="en"><head><meta charset="utf-8"></head>
<?php

use Denner\Client\TranslationsClient;

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

$client = TranslationsClient::factory($config);

$response = $client->listJobs($params);

var_dump($response->getResources());
