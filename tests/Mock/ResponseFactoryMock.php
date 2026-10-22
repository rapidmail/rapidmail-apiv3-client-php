<?php

namespace Rapidmail\ApiClientTests\Mock;

use Psr\Http\Message\ResponseInterface;
use Rapidmail\ApiClient\Http\HttpClientInterface;
use Rapidmail\ApiClient\Service\Response\HalResponse;
use Rapidmail\ApiClient\Service\Response\HalResponsePaginationIterator;
use Rapidmail\ApiClient\Service\Response\HalResponseResourceIterator;
use Rapidmail\ApiClient\Service\Response\ResponseFactory;

class ResponseFactoryMock extends ResponseFactory
{

    private ?string $lastResourceKey = null;

    private ?HalResponse $expectedHalResponse = null;

    private ?HalResponseResourceIterator $expectedHalResourceIterator = null;

    /**
     * @return ResponseFactoryMock
     */
    public function setExpectedHalResponse(HalResponse $expectedHalResponse)
    {
        $this->expectedHalResponse = $expectedHalResponse;

        return $this;
    }

    /**
     * @return ResponseFactoryMock
     */
    public function setExpectedHalResourceIterator(HalResponseResourceIterator $expectedHalResourceIterator)
    {
        $this->expectedHalResourceIterator = $expectedHalResourceIterator;

        return $this;
    }

    /**
     * Returns the LastResourceKey
     *
     * @return string|null
     */
    public function getLastResourceKey()
    {
        return $this->lastResourceKey;
    }

    /**
     * @inheritDoc
     */
    public function newHalResponse(HttpClientInterface $client, ResponseInterface $response): HalResponse
    {
        return $this->expectedHalResponse ?? new HalResponse($client, $this);
    }

    /**
     * @inheritDoc
     */
    public function newHalResponseResourceIterator(
        HttpClientInterface $client,
        string $resourceKey,
        ResponseInterface $response
    ): HalResponseResourceIterator {
        $this->lastResourceKey = $resourceKey;
        return $this->expectedHalResourceIterator ?? new HalResponseResourceIterator(
            new HalResponsePaginationIterator(new HalResponse($client, $this)),
            $resourceKey
        );
    }

}