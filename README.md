# jumbo-client

[![Build Status](https://travis-ci.org/detailnet/jumbo-client.svg?branch=master)](https://travis-ci.org/detailnet/jumbo-client)
[![Coverage Status](https://img.shields.io/coveralls/detailnet/jumbo-client.svg)](https://coveralls.io/r/detailnet/jumbo-client)
[![Latest Stable Version](https://poser.pugx.org/detailnet/jumbo-client/v/stable.svg)](https://packagist.org/packages/detailnet/jumbo-client)
[![Latest Unstable Version](https://poser.pugx.org/detailnet/jumbo-client/v/unstable.svg)](https://packagist.org/packages/detailnet/jumbo-client)

API Client for Jumbo Web Services

## Installation
Install the library through [Composer](http://getcomposer.org/) using the following steps:

  1. `cd my/project/directory`
  
  2. Create a `composer.json` file with following contents (or update your existing file accordingly):

     ```json
     {
         "require": {
             "detailnet/jumbo-client": "1.x-dev"
         }
     }
     ```
  3. Install Composer via `curl -s http://getcomposer.org/installer | php` (on Windows, download
     the [installer](http://getcomposer.org/installer) and execute it with PHP)
     
  4. Run `php composer.phar self-update`
     
  5. Run `php composer.phar install`

## Usage

See the following example for how to use the library:

```php
// App-ID and App-Key are required to authenticate the client
$config = array(
    'app_id' => 'your-app-id',
    'app_key' => 'your-app-key',
);

// Create the client (e.g. the client for Jumbo Assets Service)
$client = AssetsClient::factory($config);

// Send a request
$params = array('query' => 'test');
$response = $client->listAssets($params);
```

More examples can be found in the [examples](examples) directory.
