<?php

namespace Rapidmail\ApiClient\Service\V1\Api\Recipientlists\Recipientlist;

use GuzzleHttp\RequestOptions;
use Rapidmail\ApiClient\Exception\ApiException;
use Rapidmail\ApiClient\Exception\InvalidArgumentException;
use Rapidmail\ApiClient\Http\HttpClientInterface;
use Rapidmail\ApiClient\Service\AbstractService;
use Rapidmail\ApiClient\Service\Response\HalResponse;
use Rapidmail\ApiClient\Service\Response\HalResponseResourceIterator;
use Rapidmail\ApiClient\Service\Response\ResponseFactory;
use Rapidmail\ApiClient\Service\V1\Api\Recipientlists\Recipientlist\Parameter\ParameterFactory;
use Rapidmail\ApiClient\Service\V1\Api\Recipientlists\Recipientlist\Parameter\RecipientlistActivityStatsParam;
use Rapidmail\ApiClient\Service\V1\Api\Recipientlists\Recipientlist\Parameter\RecipientlistCreateParam;

/**
 * API Service to manage recipientlists
 */
class RecipientlistService extends AbstractService
{

    protected ParameterFactory $parameterFactory;

    /**
     * Constructor
     *
     * @param HttpClientInterface $client
     * @param ResponseFactory $responseFactory
     * @param ParameterFactory $parameterFactory
     */
    public function __construct(
        HttpClientInterface $client,
        ResponseFactory $responseFactory,
        ParameterFactory $parameterFactory
    ) {
        $this->parameterFactory = $parameterFactory;
        parent::__construct($client, $responseFactory);
    }

    /**
     * @inheritDoc
     */
    protected function getResourcePath(): string
    {
        return 'recipientlists';
    }

    /**
     * @return ParameterFactory
     */
    public function params(): ParameterFactory
    {
        return $this->parameterFactory;
    }

    /**
     * Get a list of recipientlists from current account
     *
     * @param array $filter
     * @return HalResponseResourceIterator
     * @throws ApiException
     */
    public function query(array $filter = []): HalResponseResourceIterator
    {

        return $this
            ->responseFactory
            ->newHalResponseResourceIterator(
                $this->client,
                'recipientlists',
                $this->_query(
                    $filter
                )
            );

    }

    /**
     * Create a new recipientlist
     *
     * @param string|array|RecipientlistCreateParam
     * @return HalResponse
     * @throws ApiException
     */
    public function create($data = []): HalResponse
    {

        $method = 'POST';
        $uri = $this->getResourcePath();

        return $this->upsert($method, $uri, $data);

    }

    /**
     * Get details for a specific recipientlist
     *
     * @param int $recipientlistId
     * @return HalResponse
     * @throws ApiException
     */
    public function get(int $recipientlistId): HalResponse
    {

        return $this
            ->responseFactory
            ->newHalResponse(
                $this->client,
                $this->_get($recipientlistId)
            );

    }

    /**
     * Delete recipientlist specified by ID
     *
     * @param int $recipientlistId
     * @return bool
     * @throws ApiException
     */
    public function delete(int $recipientlistId): bool
    {
        return $this->_delete($recipientlistId)->getStatusCode() == 204;
    }

    /**
     * Update a specific recipientlist allowing partial updates
     *
     * @param int $recipientlistId
     * @param string|array|RecipientlistCreateParam $data
     * @return HalResponse
     * @throws ApiException
     */
    public function update(int $recipientlistId, $data = []): HalResponse
    {

        $method = 'PATCH';
        $uri = "{$this->getResourcePath()}/{$recipientlistId}";

        return $this->upsert($method, $uri, $data);

    }

    /**
     * Get activity stats for a specific recipientlist
     *
     * @param int $recipientlistId
     * @param array|RecipientlistActivityStatsParam $filter
     * @return HalResponse
     * @throws ApiException
     */
    public function activityStats(int $recipientlistId, $filter = []): HalResponse
    {

        if (is_array($filter)) {
            $filter = $this->params()->newActivityStatsParam($filter);
        }

        if (!$filter instanceof RecipientlistActivityStatsParam) {

            throw new InvalidArgumentException(
                'Invalid filter provided. Must be an array or RecipientlistActivityStatsParam'
            );

        }

        return $this
            ->responseFactory
            ->newHalResponse(
                $this->client,
                $this->client->request(
                    'GET',
                    "{$this->getResourcePath()}/{$recipientlistId}/stats/activity",
                    [
                        'query' => $filter->toArray()
                    ]
                )

            );

    }

    /**
     * Creates or updates a recipientlist
     *
     * @param string $method
     * @param string $uri
     * @param array|RecipientlistCreateParam $data
     * @return HalResponse
     * @throws ApiException
     */
    private function upsert(string $method, string $uri, $data = []): HalResponse
    {

        if (is_string($data)) {

            // Assume recipientlist name

            $data = $this->params()->newCreateParam()->setName($data);

        }

        if (is_array($data)) {
            $data = $this->params()->newCreateParam($data);
        }

        if (!$data instanceof RecipientlistCreateParam) {

            throw new InvalidArgumentException(
                'Invalid filter provided. Must be an array or RecipientlistCreateParam'
            );

        }

        $response = $this->client->request(
            $method,
            $uri,
            [
                RequestOptions::JSON => $data->toArray()
            ]

        );

        return $this->responseFactory->newHalResponse($this->client, $response);
    }

}