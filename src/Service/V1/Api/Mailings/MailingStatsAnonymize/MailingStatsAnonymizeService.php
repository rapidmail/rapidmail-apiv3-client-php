<?php

namespace Rapidmail\ApiClient\Service\V1\Api\Mailings\MailingStatsAnonymize;

use Rapidmail\ApiClient\Exception\ApiException;
use Rapidmail\ApiClient\Service\AbstractService;

/**
 * API service to anonymize stats for a sent mailing
 */
class MailingStatsAnonymizeService extends AbstractService
{

    /**
     * @inheritDoc
     */
    protected function getResourcePath(): string
    {
        return 'mailings';
    }

    /**
     * Anonymize mailing stats for a specific sent mailing
     *
     * This operation is only supported, if the respective mailing has already been sent.
     *
     * @throws ApiException
     */
    public function anonymize(int $mailingId): bool
    {
        return $this
                ->client
                ->request(
                    'PUT',
                    "{$this->getResourcePath()}/{$mailingId}/stats/anonymize"
                )
                ->getStatusCode() == 200;
    }

}
