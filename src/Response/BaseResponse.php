<?php

namespace Jumbo\Client\Response;

use GuzzleHttp\Psr7\Response as PsrResponse;
use Jumbo\Client\Exception;

abstract class BaseResponse implements
    Response
{
    /** @var PsrResponse */
    protected $response;

    /** @var array */
    protected $data = [];

    public function __construct(PsrResponse $response)
    {
        $this->response = $response;
        $this->data = $this->extractData();
    }

    public function getHttpResponse(): PsrResponse
    {
        return $this->response;
    }

    public function toArray(): array
    {
        return $this->getData();
    }

    protected function getData(): array
    {
        return $this->data;
    }

    private function extractData(): array
    {
        try {
            $data = $this->decodeJson($this->getHttpResponse()->getBody());

            return is_array($data) ? $data : [];
        } catch (\Exception $e) {
            throw new Exception\RuntimeException(
                sprintf('Failed extract data from HTTP response: %s', $e->getMessage()),
                $e->getCode(),
                $e
            );
        }
    }

    private function decodeJson(string $value): array
    {
        $data = json_decode($value, true);

        if (!is_array($data)) {
            $error = json_last_error();

            if ($error !== JSON_ERROR_NONE) {
                $message = json_last_error_msg();

                if ($message === false) {
                    $message = 'Unknown error';
                }

                throw new Exception\RuntimeException(
                    sprintf('Unable to decode JSON: %s', $message)
                );
            }
        }

        return $data;
    }
}
