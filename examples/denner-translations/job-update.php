<!doctype html>
<html lang="en"><head><meta charset="utf-8"></head>
<?php

use Denner\Client\TranslationsClient;

$config = require realpath(__DIR__ . '/../bootstrap.php');

$jobId = @$_GET['job_id'] ?: '44444444-aaaa-4444-aaaa-444444444444';

if (!$jobId) {
    throw new RuntimeException('Missing or invalid parameter "job_id"');
}

$params = array(
    'job_id' => $jobId,
    'status' => 'closed',
);

$client = TranslationsClient::factory($config);

$response = $client->updateJob($params);

var_dump("Response:", $response, "Data:", $response->toArray());
