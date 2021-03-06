<?php

namespace Jumbo\Client\Response;

use ArrayIterator;
use Jumbo\Client\Exception;
use Jumbo\Client\Response\Resource as ClientResource;
use GuzzleHttp\Command\Guzzle\Operation;
use GuzzleHttp\Psr7\Response as PsrResponse;
use IteratorAggregate;
use function is_object;
use function is_string;
use function method_exists;
use function sprintf;

class ListResponse extends BaseResponse implements
    IteratorAggregate
{
    public const OPTION_DATA_ROOT = 'data_root';

    /** @var ClientResource[] */
    protected array $resources = [];
    private string $dataRoot;

    public static function fromOperation(Operation $operation, PsrResponse $response): ListResponse
    {
        $operationConfig = $operation->toArray();

        if (!isset($operationConfig['responseDataRoot'])) {
            throw new Exception\RuntimeException(
                sprintf(
                    'No response data root configured for operation "%s"',
                    $operation->getName()
                )
            );
        }

        return new static($response, [self::OPTION_DATA_ROOT => $operationConfig['responseDataRoot']]);
    }

    public function __construct(PsrResponse $response, array $options = [])
    {
        parent::__construct($response, $options);

        $dataRoot = $this->getOption(self::OPTION_DATA_ROOT);

        if ($dataRoot === null
            || (!is_object($dataRoot) && !is_string($dataRoot))
            || (is_object($dataRoot) && !method_exists($dataRoot, '__toString'))
        ) {
            throw new Exception\RuntimeException(
                sprintf(
                    'Option "%s" is mandatory, has to be a string or implement __toString',
                    self::OPTION_DATA_ROOT
                )
            );
        }

        $this->dataRoot = (string) $dataRoot;

        foreach ($this->getRawResources() as $resourceData) {
            $this->resources[] = new Resource($resourceData);
        }
    }

    /**
     * @return ClientResource[]
     */
    public function getResources(): array
    {
        return $this->resources;
    }

    /**
     * Count resources on current page
     */
    public function getResourceCount(): int
    {
        return count($this->getResources());
    }

    /**
     * Count resources on all pages
     */
    public function getTotalResourceCount(): ?int
    {
        return isset($this->getData()['total_items']) ? (integer) $this->getData()['total_items'] : null;
    }

    /**
     * Count number of pages
     */
    public function getPageCount(): ?int
    {
        return isset($this->getData()['page_count']) ? (integer) $this->getData()['page_count'] : null;
    }

    /**
     * Get page size
     */
    public function getPageSize(): ?int
    {
        return isset($this->getData()['page_size']) ? (integer) $this->getData()['page_size'] : null;
    }

    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->getResources());
    }

    private function getRawResources(): array
    {
        $data = $this->getData();

        if (!isset($data[$this->dataRoot])) {
            throw new Exception\RuntimeException(
                sprintf('Data root "%s" does not exist', $this->dataRoot)
            );
        }

        if (!is_array($data[$this->dataRoot])) {
            throw new Exception\RuntimeException(
                sprintf('Data root "%s" is not an array', $this->dataRoot)
            );
        }

        $resources = $data[$this->dataRoot];

        // Make sure the data for all resources are arrays
        $resourceIndex = 0;

        foreach ($resources as $resourceData) {
            if (!is_array($resourceData)) {
                throw new Exception\RuntimeException(
                    sprintf('Resource #%d is not an array', $resourceIndex)
                );
            }

            $resourceIndex++;
        }

        return $resources;
    }
}
