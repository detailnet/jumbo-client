<?php

namespace Jumbo\Client\Response;

use ArrayIterator;

/**
 * Trait implementing \ArrayAccess, \Countable, and \IteratorAggregate
 */
trait HasDataTrait
{
    /**
     * @return ArrayIterator
     */
    public function getIterator()
    {
        return new ArrayIterator($this->getIterationData());
    }

    /**
     * @param string|integer $offset
     * @return mixed|null
     */
    public function offsetGet($offset)
    {
        $data = $this->getIterationData();

        if (isset($data[$offset])) {
            return $data[$offset];
        }

        return null;
    }

    /**
     * @param string|integer $offset
     * @param mixed $value
     */
    public function offsetSet($offset, $value)
    {
//        $this->data[$offset] = $value;
        // Do nothing
    }

    /**
     * @param string|integer $offset
     * @return boolean
     */
    public function offsetExists($offset)
    {
        return isset($this->getIterationData()[$offset]);
    }

    /**
     * @param string|integer $offset
     */
    public function offsetUnset($offset)
    {
//        unset($this->data[$offset]);
        // Do nothing
    }

    /**
     * @return integer
     */
    public function count()
    {
        return count($this->getIterationData());
    }

    /**
     * @return array
     */
    abstract protected function getIterationData();
}
