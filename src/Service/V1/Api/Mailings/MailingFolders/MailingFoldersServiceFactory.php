<?php

declare(strict_types=1);

namespace Rapidmail\ApiClient\Service\V1\Api\Mailings\MailingFolders;

use Rapidmail\ApiClient\Http\HttpClientInterface;
use Rapidmail\ApiClient\Service\Response\ResponseFactory;
use Rapidmail\ApiClient\Service\ServiceFactoryInterface;

class MailingFoldersServiceFactory implements ServiceFactoryInterface
{
    /**
     * @inheritDoc
     */
    public function create($dependencies = [])
    {

        return new MailingFoldersService(
            $dependencies[HttpClientInterface::class],
            $dependencies[ResponseFactory::class]
        );

    }

}