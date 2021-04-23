<?php

namespace Jumbo\Client\Response;

use ArrayAccess;
use Jumbo\Client\Exception;
use JmesPath\Env as JmesPath;

class Resource implements
    ArrayAccess
{
    protected array $data = [];

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function has(string $key): bool
    {
        return $this->get($key) !== null;
    }

    /**
     * @param mixed $default
     * @return mixed
     */
    public function get(string $key, $default = null)
    {
        return isset($this->data[$key]) ? $this->data[$key] : $default;
    }

    /**
     * @return mixed|null
     */
    public function search(string $expression)
    {
        return JmesPath::search($expression, $this->data);
    }

    public function toArray(): array
    {
        return $this->data;
    }

    public function __toString(): string
    {
        $jsonData = json_encode($this->data, JSON_PRETTY_PRINT);

        return <<<EOT
Model Data
----------
Data can be retrieved from the model object using the get() method of the
model (e.g., `\$resource->get(\$key)`) or "accessing the result like an
associative array (e.g. `\$resource['key']`). You can also execute JMESPath
expressions on the result data using the search() method.

{$jsonData}

EOT;
    }

    /**
     * @param mixed $offset
     * @return mixed|null
     */
    public function offsetGet($offset)
    {
        return $this->get($offset);
    }

    /**
     * @param mixed $offset
     * @param mixed $value
     */
    public function offsetSet($offset, $value)
    {
        throw new Exception\RuntimeException(
            sprintf('Resource is read-only; cannot set "%s"', $offset)
        );
    }

    /**
     * @param mixed $offset
     * @return bool
     */
    public function offsetExists($offset)
    {
        return $this->has($offset);
    }

    /**
     * @param mixed $offset
     */
    public function offsetUnset($offset)
    {
        throw new Exception\RuntimeException(
            sprintf('Resource is read-only; cannot unset "%s"', $offset)
        );
    }
}
