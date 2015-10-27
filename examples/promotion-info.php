<?php

throw new \Exception('API endpoint /api/promotions/{promotion_id} (still) not available');

use Denner\Client\ArticlesClient;

$config = require 'bootstrap.php';

$promotionId = @$_GET['promotion_id'] ?: 'ad9b0489-3fd0-4101-963d-4cd43b545692';

if (!$promotionId) {
    throw new RuntimeException('Missing or invalid parameter "promotion_id"');
}

$client = ArticlesClient::factory($config);

$response = $client->fetchPromotion(array('promotion_id' => $promotionId));

var_dump($response);
