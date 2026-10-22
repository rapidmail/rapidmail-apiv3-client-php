<?php

namespace Rapidmail\ApiClient\Http;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\UriInterface;
use Rapidmail\ApiClient\Exception\ApiException;

interface HttpClientInterface
{

    /**
     * HTTP request wrapper
     *
     * @param string $method HTTP method.
     * @param string|UriInterface $uri URI object or string.
     * @param array $options Request options to apply.
     *
     * @throws ApiException
     */
    public function request(string $method, $uri, array $options = []): ResponseInterface;

}