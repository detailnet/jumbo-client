<?php

namespace Denner\Client;

use Detail\Normalization\Normalizer\Service\NormalizerAwareTrait;

use GuzzleHttp\Command\Guzzle\GuzzleClient as ServiceClient;

use Denner\Client\Subscriber;
use Denner\Client\Exception;

abstract class AbstractClient extends ServiceClient
{
    use NormalizerAwareTrait;

    /**
     * @param string $name
     * @param array $arguments
     * @return array
     */
    public function __call($name, array $arguments)
    {
        $operation = $this->getDescription()->getOperation($name);

        if ($operation === null) {
            throw new Exception\RuntimeException(
                sprintf(
                    'Could not find operation for: "%s"',
                    $name
                )
            );
        }

        $config = $operation->toArray();

        if (!isset($config['model'])) {
            throw new Exception\RuntimeException(
                sprintf(
                    'No "model" was specified : "%s"',
                    $name
                )
            );
        }

        $response = $this->execute(
            $this->getCommand(
                $name,
                isset($arguments[0]) ? $arguments[0] : []
            )
        );

        $results = $response;

        if (isset($config['rootNode']) && !isset($response[$config['rootNode']])) {
            throw new Exception\RuntimeException(
                sprintf(
                    'Could not find rootNode in resultSet: "%s"',
                    $config['rootNode']
                )
            );
        }

        $rootNode = null;

        if (isset($config['rootNode'])) {
            $rootNode = $config['rootNode'];
        }

        return $this->denormalize($results, $config['model'], $rootNode);
    }

    /**
     * @param array $results
     * @param string $class
     * @param null|string $rootNode
     * @return array
     */
    protected function deNormalize(array $results = array(), $class, $rootNode = null)
    {
        $items = array();

        if ($rootNode) {
            $results = $results[$rootNode];
        }

        foreach ($results as $row) {
            $items[] = $this->deNormalizeRow($row, $class);
        }

        return $items;
    }

    /**
     * @param array $row
     * @param string $class
     * @return object
     */
    protected function deNormalizeRow(array $row, $class)
    {
        return $this->getNormalizer()->denormalize($row, $class);
    }
}
