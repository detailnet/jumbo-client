<?php

namespace Denner\Client;

use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Collection;
use GuzzleHttp\Command\Guzzle\Description as ServiceDescription;
use GuzzleHttp\Command\Guzzle\GuzzleClient as ServiceClient;

use Denner\Client\Subscriber;
use ReflectionClass;

abstract class DennerClient extends ServiceClient
{
    const CLIENT_VERSION = '0.1.0';

    public static function factory($options = array())
    {
        $defaultOptions = array(
            'base_url' => self::getDefaultServiceUrl(),
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

        $serviceDescriptionFile = __DIR__ . sprintf('/ServiceDescription/%s.php', self::getServiceDescriptionName());

        if (!file_exists($serviceDescriptionFile)) {
            throw new Exception\RuntimeException(
                sprintf('Service description does not exist at "%s"', $serviceDescriptionFile)
            );
        }

        $description = new ServiceDescription(require $serviceDescriptionFile);
        $client = new static($httpClient, $description);

        return $client;
    }

    /**
     * @return string
     */
    protected static function getDefaultServiceUrl()
    {
        $serviceName = self::getServiceName();

        return sprintf('https://denner-%s.detailnet.ch/api/', $serviceName);
    }

    /**
     * @param boolean $asSnake
     * @return string
     */
    protected static function getServiceName($asSnake = true)
    {
        $className = (new ReflectionClass(static::CLASS))->getShortName();
        $serviceName = str_replace('Client', '', $className);

        if ($asSnake !== false) {
            $serviceName = ltrim(strtolower(preg_replace('/[A-Z]/', '-$0', $serviceName)), '-');
            $serviceName = preg_replace('/[-]+/', '-', $serviceName);
        }

        return $serviceName;
    }

    /**
     * @return string
     */
    protected static function getServiceDescriptionName()
    {
        return self::getServiceName(false);
    }
}
