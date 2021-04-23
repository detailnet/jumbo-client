<?php

namespace Jumbo\Client\Response;

class PlainTextResponse extends ResourceResponse
{
    protected function extractData(): array
    {
        return [
            'response' => substr($this->getHttpResponse()->getBody()->getContents(), 1, -1),
        ];
    }
}
