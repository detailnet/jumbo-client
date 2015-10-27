<?php

namespace Denner\Client;

use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Collection;
use GuzzleHttp\Command\Guzzle\Description as ServiceDescription;
use GuzzleHttp\Command\Guzzle\GuzzleClient as ServiceClient;

//use Denner\Client\Exception;
use Denner\Client\Subscriber;

/**
 * Denner API client.
 *
 * @method array listAdvertisedArticles(array $params = array())
 * @method array fetchAdvertisedArticle(array $params = array())
 * @method array listPromotions(array $params = array())
 * // @method array fetchPromotion(array $params = array())
 */
class ArticlesClient extends ServiceClient
{
    const CLIENT_VERSION = '0.1.0';

    public static function factory($options = array())
    {
        $defaultOptions = array(
            'base_url' => 'https://denner-articles.detailnet.ch/api/',
            'defaults' => array(
                // We're using our own error handler
                // (this disabled the use of the internal HttpError subscriber)
                'exceptions' => false,
                // Float describing the number of seconds to wait while trying to connect to a server.
                // 0 was the default (wait indefinitely).
                'connect_timeout' => 10,
                // Float describing the timeout of the request in seconds.
                // 0 was the default (wait indefinitely).
                'timeout' => 60, // 60 seconds, may be overridden by individual operations
            ),
        );

//        $requiredOptions = array();
//
//        foreach ($requiredOptions as $optionName) {
//            if (!isset($options[$optionName]) || $options[$optionName] === '') {
//                throw new Exception\InvalidArgumentException(
//                    sprintf('Missing required configuration option "%s"', $optionName)
//                );
//            }
//        }

        $config = Collection::fromConfig($options, $defaultOptions);

        $headers = array(
            'Accept' => 'application/json',
            'User-Agent' => 'denner-client/' . self::CLIENT_VERSION,
        );

        if (isset($options['app_id'])) {
            $headers['App-ID'] = $options['app_id'];
        }

        if (isset($options['app_key'])) {
            $headers['App-Key'] = $options['app_key'];
        }

        $httpClient = new HttpClient($config->toArray());
        $httpClient->setDefaultOption('headers', $headers);
        $httpClient->getEmitter()->attach(new Subscriber\ErrorHandler());

        $description = new ServiceDescription(
            require __DIR__ . '/ServiceDescription/Articles.php'
        );

        $client = new self($httpClient, $description);

        return $client;
    }
}
