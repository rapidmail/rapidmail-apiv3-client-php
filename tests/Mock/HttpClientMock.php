<?php

namespace Rapidmail\ApiClientTests\Mock;

use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Rapidmail\ApiClient\Http\HttpClientInterface;

class HttpClientMock implements HttpClientInterface
{

    private Response $expectedResponse;

    private ?string $lastMethod = null;

    /**
     * @var string|null
     */
    private $lastUri;

    private ?array $lastOptions = null;

    /**
     * Constructor
     *
     * @param Response|null $expectedResponse
     */
    public function __construct(?Response $expectedResponse = null)
    {
        $this->expectedResponse = $expectedResponse ?? new Response();
    }

    /**
     * @inheritDoc
     */
    public function request(string $method, $uri, array $options = []): ResponseInterface
    {

        $this->lastMethod = $method;
        $this->lastUri = $uri;
        $this->lastOptions = $options;

        return $this->expectedResponse;

    }

    /**
     * Sets the expected Response
     *
     * @param Response $expectedResponse
     * @return HttpClientMock
     */
    public function setExpectedResponse(Response $expectedResponse)
    {
        $this->expectedResponse = $expectedResponse;

        return $this;
    }

    /**
     * Returns the LastMethod
     *
     * @return string|null
     */
    public function getLastMethod()
    {
        return $this->lastMethod;
    }

    /**
     * Returns the LastUri
     *
     * @return string|null
     */
    public function getLastUri()
    {
        return $this->lastUri;
    }

    /**
     * Returns the LastOptions
     *
     * @return array|null
     */
    public function getLastOptions()
    {
        return $this->lastOptions;
    }

}