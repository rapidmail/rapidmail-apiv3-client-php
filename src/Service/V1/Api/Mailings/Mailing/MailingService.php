<?php

namespace Rapidmail\ApiClient\Service\V1\Api\Mailings\Mailing;

use GuzzleHttp\RequestOptions;
use Rapidmail\ApiClient\Exception\ApiException;
use Rapidmail\ApiClient\Exception\InvalidArgumentException;
use Rapidmail\ApiClient\Http\HttpClientInterface;
use Rapidmail\ApiClient\Service\AbstractService;
use Rapidmail\ApiClient\Service\Response\HalResponse;
use Rapidmail\ApiClient\Service\Response\HalResponseResourceIterator;
use Rapidmail\ApiClient\Service\Response\ResponseFactory;
use Rapidmail\ApiClient\Service\V1\Api\Mailings\Mailing\Parameter\MailingCreateParam;
use Rapidmail\ApiClient\Service\V1\Api\Mailings\Mailing\Parameter\MailingQueryParam;
use Rapidmail\ApiClient\Service\V1\Api\Mailings\Mailing\Parameter\ParameterFactory;

/**
 * API service to manage mailings
 */
class MailingService extends AbstractService
{

    protected ParameterFactory $parameterFactory;

    /**
     * Constructor
     */
    public function __construct(
        HttpClientInterface $client,
        ResponseFactory $responseFactory,
        ParameterFactory $parameterFactory
    ) {
        parent::__construct($client, $responseFactory);
        $this->parameterFactory = $parameterFactory;
    }

    /**
     * @inheritDoc
     */
    protected function getResourcePath(): string
    {
        return 'mailings';
    }

    public function params(): ParameterFactory
    {
        return $this->parameterFactory;
    }

    /**
     * Get detailed info about single mailing
     *
     * @throws ApiException
     */
    public function get(int $mailingId): HalResponse
    {

        return $this->responseFactory->newHalResponse(
            $this->client,
            $this->_get($mailingId)
        );

    }

    /**
     * List all mailings
     *
     * @param MailingQueryParam|array $filter
     *
     * @throws ApiException
     */
    public function query($filter = []): HalResponseResourceIterator
    {

        if (is_array($filter)) {
            $filter = $this->params()->newQueryParam($filter);
        }

        if (!$filter instanceof MailingQueryParam) {

            throw new InvalidArgumentException(
                'Invalid filter provided. Must be an array or MailingQueryParam'
            );

        }

        return $this->responseFactory->newHalResponseResourceIterator(
            $this->client,
            'mailings',
            $this->_query(
                $filter->toArray()
            )
        );

    }

    /**
     * Delete a single mailing
     *
     * @throws ApiException
     */
    public function delete(int $mailingId): bool
    {
        return $this->_delete($mailingId)->getStatusCode() == 204;
    }

    /**
     * Pause a mailing
     *
     * @throws ApiException
     */
    public function pause(int $mailingId): bool
    {
        return $this
                ->client
                ->request(
                    'POST',
                    "{$this->getResourcePath()}/{$mailingId}/pause"
                )
                ->getStatusCode() == 200;
    }

    /**
     * Cancel a mailing
     *
     * @throws ApiException
     */
    public function cancel(int $mailingId, string $reason): bool
    {
        return $this
                ->client
                ->request(
                    'POST',
                    "{$this->getResourcePath()}/{$mailingId}/cancel",
                    [
                        RequestOptions::JSON => [
                            "reason" => $reason
                        ]
                    ]
                )
                ->getStatusCode() == 200;

    }

    /**
     * Create a new mailing using zip file content
     *
     * @param array|MailingCreateParam $data
     * @throws ApiException
     */
    public function create($data = []): HalResponse
    {

        if (is_array($data)) {
            $data = $this->params()->newCreateParam($data);
        }

        if (!$data instanceof MailingCreateParam) {

            throw new InvalidArgumentException(
                'Invalid filter provided. Must be an array or MailingCreateParam'
            );

        }

        $response =
            $this->client->request(
                'POST',
                $this->getResourcePath(),
                [
                    RequestOptions::JSON => $data->toArray()
                ]

            );

        return $this->responseFactory->newHalResponse($this->client, $response);

    }

}
