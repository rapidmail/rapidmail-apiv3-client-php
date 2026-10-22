<?php

namespace Rapidmail\ApiClient;

use Rapidmail\ApiClient\Exception\IncompatiblePlatformException;
use Rapidmail\ApiClient\Exception\NotImplementedException;
use Rapidmail\ApiClient\Http\HttpClientFactory;
use Rapidmail\ApiClient\Service\ServiceFactory;
use Rapidmail\ApiClient\Service\V1\Api\ApiUsers\ApiUser\ApiUserService;
use Rapidmail\ApiClient\Service\V1\Api\Blacklist\Blacklist\BlacklistService;
use Rapidmail\ApiClient\Service\V1\Api\Jobs\Job\JobService;
use Rapidmail\ApiClient\Service\V1\Api\Mailings\MailingFolders\MailingFoldersService;
use Rapidmail\ApiClient\Service\V1\Api\Mailings\MailingRecipients\MailingRecipientsService;
use Rapidmail\ApiClient\Service\V1\Api\Mailings\MailingStatsAnonymize\MailingStatsAnonymizeService;
use Rapidmail\ApiClient\Service\V1\Api\Mailings\MailingStats\MailingStatsService;
use Rapidmail\ApiClient\Service\V1\Api\Mailings\Mailing\MailingService;
use Rapidmail\ApiClient\Service\V1\Api\Recipientlists\Recipientlist\RecipientlistService;
use Rapidmail\ApiClient\Service\V1\Api\Recipients\Recipient\RecipientService;
use Rapidmail\ApiClient\Service\V1\Api\TrxEmails\TrxEmail\TrxEmailService;
use Rapidmail\ApiClient\Util\PlatformRequirements;

if (is_file(__DIR__ . '/../vendor/autoload.php')) {
    require_once __DIR__ . '/../vendor/autoload.php';
}

/**
 * rapidmail API v3 client
 */
class Client
{

    /**
     * @var string
     */
    const VERSION = '2.0.0';

    private ServiceFactory $serviceFactory;

    /**
     * Constructor
     *
     * @param string $username
     * @param string $password
     * @throws IncompatiblePlatformException
     */
    public function __construct(...$args)
    {

        // Assume username + password by default

        $config = [
            'auth' => [
                is_string($args[0] ?? null) ? $args[0] : '',
                is_string($args[1] ?? null) ? $args[1] : ''
            ]
        ];

        // Assume a configuration array was provided

        if (is_array($args[0] ?? null)) {
            $config = $args[0];
        }

        // Assume

        (new PlatformRequirements())->assertPlatformRequirements();

        $this->serviceFactory = new ServiceFactory(
            new HttpClientFactory(),
            $config
        );

    }

    /**
     * Creates a new mailing service
     *
     * @throws NotImplementedException
     */
    public function mailings(?string $version = null): MailingService
    {
        return $this->serviceFactory->createService('mailings', $version);
    }

    /**
     * Creates a new mailing recipients service
     *
     * @throws NotImplementedException
     */
    public function mailingRecipients(?string $version = null): MailingRecipientsService
    {
        return $this->serviceFactory->createService('mailing_recipients', $version);
    }

    /**
     * Creates a new mailing folders service
     *
     * @throws NotImplementedException
     */
    public function mailingFolders(?string $version = null): MailingFoldersService
    {
        return $this->serviceFactory->createService('mailing_folders', $version);
    }

    /**
     * Creates a new mailing stats service
     *
     * @throws NotImplementedException
     */
    public function mailingStats(?string $version = null): MailingStatsService
    {
        return $this->serviceFactory->createService('mailing_stats', $version);
    }

    /**
     * Creates a new mailing stats anonymize service
     *
     * @throws NotImplementedException
     */
    public function mailingStatsAnonymize(?string $version = null): MailingStatsAnonymizeService
    {
        return $this->serviceFactory->createService('mailing_stats_anonymize', $version);
    }

    /**
     * Creates a new API service to manage recipientlists
     *
     * @throws NotImplementedException
     */
    public function recipientlists(?string $version = null): RecipientlistService
    {
        return $this->serviceFactory->createService('recipientlists', $version);
    }

    /**
     * Creates a new API service to manage recipients
     *
     * @throws NotImplementedException
     */
    public function recipients(?string $version = null): RecipientService
    {
        return $this->serviceFactory->createService('recipients', $version);
    }

    /**
     * Creates a new API service to manage jobs
     *
     * @throws NotImplementedException
     */
    public function jobs(?string $version = null): JobService
    {
        return $this->serviceFactory->createService('jobs', $version);
    }

    /**
     * Creates a new API service to fetch transactional emails
     *
     * @throws NotImplementedException
     */
    public function transactionEmails(?string $version = null): TrxEmailService
    {
        return $this->serviceFactory->createService('trx_emails', $version);
    }

    /**
     * Creates a new API service to manage API users
     *
     * @throws NotImplementedException
     */
    public function apiUsers(?string $version = null): ApiUserService
    {
        return $this->serviceFactory->createService('apiusers', $version);
    }

    /**
     * Creates a new API service to manage blacklist entries
     *
     * @throws NotImplementedException
     */
    public function blacklist(?string $version = null): BlacklistService
    {
        return $this->serviceFactory->createService('blacklist', $version);
    }

}