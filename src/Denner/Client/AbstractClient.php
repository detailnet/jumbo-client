<?php

namespace Denner\Client;

use Detail\Normalization\Normalizer\Service\NormalizerAwareTrait;

use GuzzleHttp\Command\Guzzle\GuzzleClient as ServiceClient;

use Zend\Paginator\Adapter\ArrayAdapter;

use Denner\Client\Subscriber;
use Denner\Client\Exception;
use Denner\Client\Collection\DefaultCollection;

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

        $results = $this->execute(
            $this->getCommand(
                $name,
                isset($arguments[0]) ? $arguments[0] : []
            )
        );

        $rootNode = null;

        if (strpos($name, 'list') === 0) {
            $rootNode = $this->getRootProperty($config['model']);
        }

        return $this->denormalize($results, $config['model'], $rootNode);
    }

    /**
     * @param $model
     * @return null|string
     */
    protected function getRootProperty($model)
    {
        preg_match('/([A-Z]{1}[a-z]+)+$/', $model, $matches);
        return count($matches)
            ? strtolower(
                implode('_', (array) $matches[0])
            ) . 's'
            : null;
    }

    /**
     * @param array $result
     * @param string $class
     * @param null|string $rootNode
     * @return array
     */
    protected function deNormalize(array $result = array(), $class, $rootNode = null)
    {
        if ($rootNode === null) {
            return $this->deNormalizeRow($result, $class);
        }

        $items = array();

        foreach ($result[$rootNode] as $row) {
            $items[] = $this->deNormalizeRow($row, $class);
        }

        $results = new DefaultCollection(
            new ArrayAdapter($items)
        );

        $results->setItemCountPerPage($result['page_size']);
        $results->setDefaultItemCountPerPage($result['total_items']);
        $results->setPageRange($result['page_count']);

        return $results;
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
