<?php

namespace Jumbo\Client\Response;

use Guzzle\Http\Message\Response as HttpResponse;
use GuzzleHttp\Command\Guzzle\Operation;

use Jumbo\Client\Exception;

class ListResponse extends BaseResponse
{
    /**
     * @var string
     */
    protected $dataRoot;

    /**
     * @param Operation $operation
     * @param HttpResponse $response
     * @return ListResponse
     */
    public static function fromOperation(Operation $operation, HttpResponse $response)
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

        return new static($response, $operationConfig['responseDataRoot']);
    }

    /**
     * @param HttpResponse $response
     * @param string $dataRoot
     */
    public function __construct(HttpResponse $response, $dataRoot)
    {
        parent::__construct($response);

        $this->dataRoot = $dataRoot;
    }

    /**
     * @return Resource[]
     */
    public function getResources()
    {
        $resources = array();

        foreach ($this->getRawResources() as $resource) {
            $resources[] = new Resource($resource);
        }

        return $resources;
    }

    /**
     * @return integer
     */
    public function getResourceCount()
    {
        return $this->count();
    }

    /**
     * @return integer|null
     */
    public function getTotalResourceCount()
    {
        return isset($this->getData()['total_items']) ? (integer) $this->getData()['total_items'] : null;
    }

    /**
     * @return integer|null
     */
    public function getPageCount()
    {
        return isset($this->getData()['page_count']) ? (integer) $this->getData()['page_count'] : null;
    }

    /**
     * @return array
     */
    protected function getRawResources()
    {
        $data = $this->getData();

        if (!isset($data[$this->dataRoot])) {
            throw new Exception\RuntimeException(
                sprintf(
                    'Data root "%s" does not exist',
                    $this->dataRoot
                )
            );
        }

        if (!is_array($data[$this->dataRoot])) {
            throw new Exception\RuntimeException(
                sprintf(
                    'Data root "%s" is not an array',
                    $this->dataRoot
                )
            );
        }

        return $data[$this->dataRoot];
    }

    /**
     * @return array
     */
    protected function getIterationData()
    {
        return $this->getResources();
    }
}
