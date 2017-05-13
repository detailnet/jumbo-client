<?php

namespace Jumbo\Client;

use ReflectionClass;

use GuzzleHttp\Client as HttpClient;
//use GuzzleHttp\ClientInterface as HttpClientInterface;
use GuzzleHttp\Command\Guzzle\Description as ServiceDescription;
//use GuzzleHttp\Command\Guzzle\DescriptionInterface as ServiceDescriptionInterface;
use GuzzleHttp\Command\Guzzle\GuzzleClient as ServiceClient;

use Jumbo\Client\Exception;

abstract class JumboClient extends ServiceClient
{
    const CLIENT_VERSION = '0.1.1';

    const OPTION_APP_ID  = 'app_id';
    const OPTION_APP_KEY = 'app_key';

    const HEADER_APP_ID  = 'App-ID';
    const HEADER_APP_KEY = 'App-Key';

    public static function factory($options = array())
    {
//        $requiredOptions = array();
//
//        foreach ($requiredOptions as $optionName) {
//            if (!isset($options[$optionName]) || $options[$optionName] === '') {
//                throw new Exception\InvalidArgumentException(
//                    sprintf('Missing required configuration option "%s"', $optionName)
//                );
//            }
//        }

        // These are applied if not otherwise specified
        $defaultOptions = array(
            'base_uri' => self::getDefaultServiceUrl(),
            // Float describing the number of seconds to wait while trying to connect to a server.
            // 0 was the default (wait indefinitely).
            'connect_timeout' => 10,
            // Float describing the timeout of the request in seconds.
            // 0 was the default (wait indefinitely).
            'timeout' => 60,
        );

        $headers = array(
            'Accept' => 'application/json',
            'User-Agent' => 'jumbo-client/' . self::CLIENT_VERSION,
        );

        if (isset($options[self::OPTION_APP_ID])) {
            $headers[self::HEADER_APP_ID] = $options[self::OPTION_APP_ID];
        }

        if (isset($options[self::OPTION_APP_KEY])) {
            $headers[self::HEADER_APP_KEY] = $options[self::OPTION_APP_KEY];
        }

        // These are always applied
        $overrideOptions = array(
            // We're using our own error handling middleware,
            // so disable throwing exceptions on HTTP protocol errors (i.e., 4xx and 5xx responses).
            'http_errors' => false,
            'headers' => $headers,
        );

        // Apply options
        $config = array_replace_recursive($defaultOptions, $options, $overrideOptions);

        $httpClient = new HttpClient($config);
//        $httpClient->getEmitter()->attach(new Subscriber\Http\ProcessError());

        $serviceDescriptionFile = __DIR__ . sprintf('/ServiceDescription/%s.php', self::getServiceDescriptionName());

        if (!file_exists($serviceDescriptionFile)) {
            throw new Exception\RuntimeException(
                sprintf('Service description does not exist at "%s"', $serviceDescriptionFile)
            );
        }

        $description = new ServiceDescription(require $serviceDescriptionFile);
        $deserializer = new Deserializer($description);
        $client = new static($httpClient, $description, null, $deserializer);

        return $client;
    }

    /**
     * @return string|null
     */
    public function getServiceAppId()
    {
        return $this->getHeaderOption(self::HEADER_APP_ID);
    }

    /**
     * @return string|null
     */
    public function getServiceAppKey()
    {
        return $this->getHeaderOption(self::HEADER_APP_KEY);
    }

    /**
     * @return string
     */
    public function getServiceUrl()
    {
        return $this->getHttpClient()->getConfig('base_uri');
    }

    /**
     * @return string
     */
    protected static function getDefaultServiceUrl()
    {
        $serviceName = self::getServiceName();

        return sprintf('https://jumbo-%s.detailnet.ch/api/', $serviceName);
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

    /**
     * @param array $filtersToAdd
     * @param array $params
     */
    protected function addOrReplaceFilters(array $filtersToAdd, array &$params)
    {
        // We may need to replace already existing filters
        if (isset($params['filter']) && is_array($params['filter'])) {
            $filters = array();

            foreach ($params['filter'] as $filter) {
                if (isset($filter['property']) && isset($filtersToAdd[$filter['property']])) {
                    $filters[] = $filtersToAdd[$filter['property']];
                    unset($filtersToAdd[$filter['property']]);
                } else {
                    $filters[] = $filter;
                }
            }

            // Append remaining filters
            $filters += $filtersToAdd;
        } else {
            $filters = array_values($filtersToAdd);
        }

        $params['filter'] = $filters;
    }

//    /**
//     * @param string $method
//     * @param array $args
//     * @return mixed
//     */
//    public function __call($method, array $args)
//    {
//        // It seems we can't intercept Guzzle's request exceptions through the event system...
//        // e.g. when the endpoint is unreachable or the request times out.
//        try {
//            return parent::__call($method, $args);
//        } catch (\Exception $e) {
//            throw Exception\OperationException::wrapException($e);
//        }
//    }

    /**
     * @param string $option
     * @return string|null
     */
    protected function getHeaderOption($option)
    {
        $headers = $this->getHttpClient()->getConfig('headers');

        return array_key_exists($option, $headers) ? $headers[$option] : null;
    }
}
