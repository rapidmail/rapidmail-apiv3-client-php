<?php

namespace Rapidmail\ApiClientTests\Api;

use PHPUnit\Framework\TestCase;
use Rapidmail\ApiClientTests\Mock\HttpClientMock;
use Rapidmail\ApiClientTests\Mock\ResponseFactoryMock;

class ApiServiceTestCase extends TestCase
{

    /**
     * @var HttpClientMock
     */
    protected $client;

    /**
     * @var ResponseFactoryMock
     */
    protected $responseFactory;

    /**
     * Assert endpoint URI matched
     *
     * @param string $uri
     */
    public function assertEndpointUri($uri)
    {
        $this->assertEquals($uri, $this->client->getLastUri());
    }

    /**
     * Assert HTTP method matched
     *
     * @var string $method
     */
    public function assertHttpMethod($method)
    {
        $this->assertEquals($method, $this->client->getLastMethod());
    }

    public function assertResourceKey($resourceKey)
    {
        $this->assertEquals($resourceKey, $this->responseFactory->getLastResourceKey());
    }

    /**
     * @inheritDoc
     */
    protected function tearDown()
    {
        $this->client = null;
        $this->responseFactory = null;
    }

    /**
     * @inheritDoc
     */
    protected function setUp()
    {
        $this->client = new HttpClientMock();
        $this->responseFactory = new ResponseFactoryMock();
    }
}