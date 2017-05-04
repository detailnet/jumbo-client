<?php

namespace Jumbo\Client\Response;

use JmesPath\Env as JmesPath;

class Resource implements
    \ArrayAccess,
    \Countable,
    \IteratorAggregate
{
    use HasDataTrait;

    /**
     * @var array
     */
    protected $data = array();

    /**
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * @param string $name
     * @return boolean
     */
    public function has($name)
    {
        return isset($this->data[$name]);
    }

    /**
     * @param string $key
     * @return mixed
     */
    public function get($key)
    {
        return $this[$key];
    }

    /**
     * @param string $expression
     * @return mixed|null
     */
    public function search($expression)
    {
        return JmesPath::search($expression, $this->data);
    }

    /**
     * @return string
     */
    public function __toString()
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
     * @return array
     */
    protected function getIterationData()
    {
        return $this->data;
    }
}
