<?php

namespace Rapidmail\ApiClient\Service;

use Rapidmail\ApiClient\Exception\NotImplementedException;
use Rapidmail\ApiClient\Http\HttpClientFactory;
use Rapidmail\ApiClient\Http\HttpClientInterface;
use Rapidmail\ApiClient\Service\Response\ResponseFactory;

class ServiceFactory
{

    private array $userConfig;

    private HttpClientFactory $httpClientFactory;

    /**
     * Constructor
     */
    public function __construct(HttpClientFactory $httpClientFactory, array $config = [])
    {
        $this->httpClientFactory = $httpClientFactory;
        $this->userConfig = $config;
    }

    private function getGlobalConfig(): array
    {
        return require __DIR__ . '/../Config/services.php';
    }

    /**
     * Create a specific API service
     *
     * @throws NotImplementedException
     */
    public function createService(string $service, ?string $version = null): ServiceInterface
    {

        $globalConfig = $this->getGlobalConfig();

        if (!isset($globalConfig['services'][$service])) {
            throw new NotImplementedException("API service '{$service}' not found");
        }

        if ($version === null) {
            $version = $globalConfig['services'][$service]['current'];
        }

        if (!isset($globalConfig['services'][$service]['config'][$version])) {
            throw new NotImplementedException("API service '{$service}' for version '{$version}' not found");
        }

        $connectionSettings = array_replace_recursive(
            $globalConfig['connection'],
            ['version' => $version],
            $this->userConfig
        );

        $factoryClass = $globalConfig['services'][$service]['config'][$version]['factory_class'];
        $interfaces = class_implements($factoryClass);

        if ($interfaces === false || !in_array(ServiceFactoryInterface::class, $interfaces, true)) {
            throw new NotImplementedException("Service factory {$factoryClass} must implement ServiceFactoryInterface");
        }

        /** @var ServiceFactoryInterface $factory */
        $factory = new $factoryClass();

        return $factory->create(
            [
                HttpClientInterface::class => $this->httpClientFactory->createClient($connectionSettings),
                ResponseFactory::class => new ResponseFactory()
            ]
        );

    }

}
