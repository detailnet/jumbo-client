<?php

namespace Denner\Client\Response;

use GuzzleHttp\Command\Event\ProcessEvent;
use GuzzleHttp\Command\Guzzle\Operation;
use GuzzleHttp\Message\ResponseInterface as HttpResponseInterface;

use Denner\Client\Exception;

class ListResponse extends BaseResponse implements
    ResponseInterface
{
    use HasDataTrait;

    /**
     * @var string
     */
    protected $dataRoot;

    /**
     * @param Operation $operation
     * @param ProcessEvent $event
     * @return ResponseInterface
     */
    public static function fromOperation(Operation $operation, ProcessEvent $event)
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

        return new static($event->getResponse(), $operationConfig['responseDataRoot']);
    }

    /**
     * @param HttpResponseInterface $response
     * @param string $dataRoot
     */
    public function __construct(HttpResponseInterface $response, $dataRoot)
    {
        parent::__construct($response);

        $this->dataRoot = $dataRoot;
    }

    /**
     * @return Resource[]
     */
    public function getItems()
    {
        $items = array();

        foreach ($this->getRawItems() as $item) {
            $items[] = new Resource($item);
        }

        return $items;
    }

    /**
     * @return integer
     */
    public function getItemCount()
    {
        return $this->count();
    }

    /**
     * @return integer|null
     */
    public function getTotalItemCount()
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
    public function toArray()
    {
        return $this->getData();
    }

    /**
     * @return array
     */
    protected function getRawItems()
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
        return $this->getItems();
    }
}
