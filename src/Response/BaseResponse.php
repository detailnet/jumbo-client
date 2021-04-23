<?php

namespace Jumbo\Client\Response;

use Jumbo\Client\Exception;
use GuzzleHttp\Psr7\Response as PsrResponse;
use Throwable;
use function json_decode;
use function sprintf;

abstract class BaseResponse implements
    Response
{
    protected PsrResponse $response;
    protected array $data = [];
    /** @var array<string, mixed> */
    private array $options = [];

    /**
     * @param array<string, mixed> $options
     */
    public function __construct(PsrResponse $response, array $options = [])
    {
        $this->response = $response;
        $this->options = $options;
        $this->data = $this->extractData();
    }

    public function getHttpResponse(): PsrResponse
    {
        return $this->response;
    }

    /**
     * @param mixed|null $defaultValue
     * @return mixed
     */
    public function getOption(string $key, $defaultValue = null)
    {
        return $this->options[$key] ?? $defaultValue;
    }

    public function toArray(): array
    {
        return $this->getData();
    }

    protected function getData(): array
    {
        return $this->data;
    }

    protected function extractData(): array
    {
        try {
            return $this->decodeJson($this->getHttpResponse()->getBody());
        } catch (Throwable $e) {
            throw new Exception\RuntimeException(
                sprintf('Failed extract JSON data from HTTP response: %s', $e->getMessage()),
                $e->getCode(),
                $e
            );
        }
    }

    private function decodeJson(string $value): array
    {
        return json_decode($value, true, 512, JSON_THROW_ON_ERROR);
    }
}
