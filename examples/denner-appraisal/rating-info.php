<?php

use Denner\Client\AppraisalClient;

$config = require realpath(__DIR__ . '/../bootstrap.php');

$articleId = @$_GET['article_id'] ?: '051051';

if (!$articleId) {
    throw new RuntimeException('Missing or invalid parameter "article_id"');
}

$client = AppraisalClient::factory($config);

$response = $client->fetchRating(array('article_id' => $articleId));

var_dump("Response:", $response, "Data:", $response->toArray());
