<?php

$loader = null;
$basePath = realpath(__DIR__ . '/..') . '/';

if (file_exists($basePath . 'vendor/autoload.php')) {
    $loader = include $basePath . 'vendor/autoload.php';
} else {
    throw new RuntimeException(
        $basePath . 'vendor/autoload.php could not be found. Did you run `php composer.phar install`?'
    );
}

$config = [];

$globalConfigFile = __DIR__  .'/config.php';

if (file_exists($globalConfigFile)) {
    $config = require $globalConfigFile;
}

// That that this is not the config.php in this directory
// but the file in the directory where the script is running.
if (file_exists('config.php')) {
    $config = array_merge($config, require 'config.php');
}

return $config;
