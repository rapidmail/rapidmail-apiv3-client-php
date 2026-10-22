<?php

namespace Rapidmail\ApiClient\Service\V1\Api\Recipients\Recipient;

use Rapidmail\ApiClient\Http\HttpClientInterface;
use Rapidmail\ApiClient\Service\Response\ResponseFactory;
use Rapidmail\ApiClient\Service\ServiceFactoryInterface;
use Rapidmail\ApiClient\Service\V1\Api\Recipients\Recipient\Parameter\ParameterFactory;

class RecipientServiceFactory implements ServiceFactoryInterface
{

    /**
     * @inheritDoc
     */
    public function create(array $dependencies = []): RecipientService
    {

        return new RecipientService(
            $dependencies[HttpClientInterface::class],
            $dependencies[ResponseFactory::class],
            new ParameterFactory()
        );

    }

}