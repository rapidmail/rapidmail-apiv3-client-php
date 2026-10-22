<?php

namespace Rapidmail\ApiClient\Service\V1\Api\ApiUsers\ApiUser;

use GuzzleHttp\RequestOptions;
use Rapidmail\ApiClient\Exception\ApiException;
use Rapidmail\ApiClient\Exception\InvalidArgumentException;
use Rapidmail\ApiClient\Http\HttpClientInterface;
use Rapidmail\ApiClient\Service\AbstractService;
use Rapidmail\ApiClient\Service\Response\HalResponse;
use Rapidmail\ApiClient\Service\Response\HalResponseResourceIterator;
use Rapidmail\ApiClient\Service\Response\ResponseFactory;
use Rapidmail\ApiClient\Service\V1\Api\ApiUsers\ApiUser\Parameter\ApiUserCreateParam;
use Rapidmail\ApiClient\Service\V1\Api\ApiUsers\ApiUser\Parameter\ApiUserQueryParam;
use Rapidmail\ApiClient\Service\V1\Api\ApiUsers\ApiUser\Parameter\ParameterFactory;

/**
 * API Service to manage API users
 */
class ApiUserService extends AbstractService
{

    private ParameterFactory $parameterFactory;

    /**
     * Constructor
     */
    public function __construct(
        HttpClientInterface $client,
        ResponseFactory $responseFactory,
        ParameterFactory $parameterFactory
    ) {
        $this->parameterFactory = $parameterFactory;
        parent::__construct($client, $responseFactory);
    }

    public function params(): ParameterFactory
    {
        return $this->parameterFactory;
    }

    /**
     * @inheritDoc
     */
    protected function getResourcePath(): string
    {
        return 'apiusers';
    }

    /**
     * Get a list of API users
     *
     * @param array|ApiUserQueryParam $filter
     * @throws ApiException
     */
    public function query($filter = []): HalResponseResourceIterator
    {

        if (is_array($filter)) {
            $filter = $this->params()->newQueryParam($filter);
        }

        if (!$filter instanceof ApiUserQueryParam) {
            throw new InvalidArgumentException('Invalid filter provided. Must be an array or ApiUserQueryParam');
        }

        return $this->responseFactory->newHalResponseResourceIterator(
            $this->client,
            'apiusers',
            $this->_query(
                $filter->toArray()
            )
        );

    }

    /**
     * Get details about an API user
     *
     * @throws ApiException
     */
    public function get(int $apiUserId): HalResponse
    {

        return $this->responseFactory->newHalResponse(
            $this->client,
            $this->_get($apiUserId)
        );

    }

    /**
     * Delete a single API user
     *
     * @throws ApiException
     */
    public function delete(int $apiUserId): bool
    {
        return $this->_delete($apiUserId)->getStatusCode() == 204;
    }

    /**
     * Creates or updates an API user
     *
     * @param array|ApiUserCreateParam $data
     * @throws ApiException
     */
    private function upsert(string $method, string $uri, $data): HalResponse
    {

        if (is_array($data)) {
            $data = $this->params()->newCreateParam($data);
        }

        if (!$data instanceof ApiUserCreateParam) {

            throw new InvalidArgumentException(
                'Invalid filter provided. Must be an array or ApiUserCreateParam'
            );

        }

        $response = $this->client->request(
            $method,
            $uri,
            [
                RequestOptions::JSON => $data->toArray(),
            ]

        );

        return $this->responseFactory->newHalResponse($this->client, $response);
    }

    /**
     * Create a new API user
     *
     * Username and password will be created automatically.
     *
     * @param array|ApiUserCreateParam $data
     * @throws ApiException
     */
    public function create($data = []): HalResponse
    {

        return $this->upsert(
            'POST',
            $this->getResourcePath(),
            $data
        );

    }

    /**
     * Partially update an API user
     *
     * @param array|ApiUserCreateParam $data
     * @throws ApiException
     */
    public function update(int $apiUserId, $data = []): HalResponse
    {

        return $this->upsert(
            'PATCH',
            "{$this->getResourcePath()}/{$apiUserId}",
            $data
        );

    }

}