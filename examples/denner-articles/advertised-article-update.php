<?php

use Denner\Client\ArticlesClient;

$config = require realpath(__DIR__ . '/../bootstrap.php');

$advertisedArticleId = @$_GET['advertised_article_id'] ?: '44444444-aaaa-4444-aaaa-444444444444';

if (!$advertisedArticleId) {
    throw new RuntimeException('Missing or invalid parameter "advertised_article_id"');
}

$params = array(
    'advertised_article_id' => $advertisedArticleId,
    'manuscript_notes' => 'This is a test',
);

$client = ArticlesClient::factory($config);

$response = $client->updateAdvertisedArticle($params);

var_dump($response);
