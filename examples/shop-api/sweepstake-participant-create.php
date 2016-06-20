<?php

use Denner\Client\ShopClient;

$config = require realpath(__DIR__ . '/../bootstrap.php');
$params = array(
    "firstname" => "Michelle",
    "lastname" => "Muster",
    "address" => "Bahnhofstrasse 7",
    "zip_code" => "8034",
    "city" => "Zurich",
    "email" => "email@gmx.ch",
    "gender" => "female",
    "shop_user_id" => 123456789,
    "language" => "de",
);

$client = ShopClient::factory($config);

$response = $client->createSweepstakeParticipant($params);

var_dump($response);
