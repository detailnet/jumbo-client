<?php

use Denner\Client\AdvertisingClient;

$config = require realpath(__DIR__ . '/../bootstrap.php');

$printPublicationId = @$_GET['print_publication_id'] ?: '44444444-aaaa-4444-aaaa-444444444444';

if (!$printPublicationId) {
    throw new RuntimeException('Missing or invalid parameter "print_publication_id"');
}

$client = AdvertisingClient::factory($config);

$response = $client->fetchPrintPublication(array('print_publication_id' => $printPublicationId));

var_dump($response);
