<?php

namespace Rapidmail\ApiClient\Http;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;
use Rapidmail\ApiClient\Exception\ApiException;

class HttpClientFacade implements HttpClientInterface
{

    private ClientInterface $client;

    /**
     * Constructor
     */
    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * @inheritDoc
     */
    public function request(string $method, $uri, array $options = []): ResponseInterface
    {

        try {
            return $this->client->request($method, $uri, $options);
        } catch (GuzzleException $e) {
            throw ApiException::fromGuzzleException($e);
        }

    }

}