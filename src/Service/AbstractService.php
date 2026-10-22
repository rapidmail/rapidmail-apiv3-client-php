<?php

namespace Rapidmail\ApiClient\Service;

use Psr\Http\Message\ResponseInterface;
use Rapidmail\ApiClient\Exception\ApiException;
use Rapidmail\ApiClient\Http\HttpClientInterface;
use Rapidmail\ApiClient\Service\Response\ResponseFactory;

/**
 * Abstract Service definition
 */
abstract class AbstractService implements ServiceInterface
{

    protected HttpClientInterface $client;

    protected ResponseFactory $responseFactory;

    /**
     * Returns the resources URI path
     *
     * @return string
     */
    abstract protected function getResourcePath(): string;

    /**
     * Constructor
     *
     * @param HttpClientInterface $client
     * @param ResponseFactory $responseFactory
     */
    public function __construct(HttpClientInterface $client, ResponseFactory $responseFactory)
    {
        $this->client = $client;
        $this->responseFactory = $responseFactory;
    }

    /**
     * Retrieve a single resource
     *
     * @param int|string $id
     * @return ResponseInterface
     *
     * @throws ApiException
     */
    protected function _get($id): ResponseInterface
    {
        return $this->client->request('GET', "{$this->getResourcePath()}/{$id}");
    }

    /**
     * Query for a collection of resources
     *
     * @param array $filter
     * @return ResponseInterface
     *
     * @throws ApiException
     */
    protected function _query(array $filter = []): ResponseInterface
    {
        return $this->client->request('GET', $this->getResourcePath(), ['query' => $filter]);
    }

    /**
     * Delete a resource
     *
     * @param int|string $id
     * @return ResponseInterface
     *
     * @throws ApiException
     */
    protected function _delete($id): ResponseInterface
    {
        return $this->client->request('DELETE', "{$this->getResourcePath()}/{$id}");
    }

}
