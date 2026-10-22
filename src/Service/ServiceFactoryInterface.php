<?php

namespace Rapidmail\ApiClient\Service;

interface ServiceFactoryInterface
{

    /**
     * Create a service instance
     *
     * @param array $dependencies Optional list of dependencies
     */
    public function create(array $dependencies = []): ServiceInterface;

}