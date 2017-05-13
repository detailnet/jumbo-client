<?php

namespace Jumbo\Client\Response;

use GuzzleHttp\Psr7\Response as PsrResponse;

use Jumbo\Client\Exception;

abstract class BaseResponse implements
    Response
{
    /**
     * @var PsrResponse
     */
    protected $response;

    /**
     * @var array
     */
    protected $data;

    /**
     * @param PsrResponse $response
     */
    public function __construct(PsrResponse $response)
    {
        $this->response = $response;
        $this->data = $this->extractData();
    }

    /**
     * @return PsrResponse
     */
    public function getHttpResponse()
    {
        return $this->response;
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
    protected function getData()
    {
        return $this->data;
    }

    /**
     * @return array
     */
    private function extractData()
    {
        try {
            $data = $this->decodeJson($this->getHttpResponse()->getBody());

            return is_array($data) ? $data : array();
        } catch (\Exception $e) {
            throw new Exception\RuntimeException(
                sprintf('Failed extract data from HTTP response: %s', $e->getMessage()),
                $e->getCode(),
                $e
            );
        }
    }

    /**
     * @param string $value
     * @return array
     */
    private function decodeJson($value)
    {
        $data = json_decode($value, true);

        if ($data === false) {
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
