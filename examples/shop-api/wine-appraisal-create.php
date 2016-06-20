<?php

use Denner\Client\ShopClient;

$config = require realpath(__DIR__ . '/../bootstrap.php');

$wineId = @$_GET['wine_id'] ?: '44444444-aaaa-4444-aaaa-444444444444';

if (!$wineId) {
    throw new RuntimeException('Missing or invalid parameter "wine_id"');
}

$params = array(
    'wine_id' => $wineId,
    "wine_year" => 2013,
    "title" => "un très très bon vin",
    "description" => "mais ce n'est pas du zinfandel !! c'est du PRIMITIVO !! le cépage ORIGINAL !!! Denner, qu'est ce qui vous arrive ???",
    "rating" => 5,
    "display_name" => "Hans M.",
    "city" => "Cossonay",
    "language" => "fr",
);

$client = ShopClient::factory($config);

$response = $client->createWineAppraisal($params);

var_dump($response);
