<?php

namespace Rapidmail\ApiClient\Service\V1\Api\ApiUsers\ApiUser\Parameter;

class ParameterFactory
{

    /**
     * Creates a new query parameter
     */
    public function newQueryParam(array $input = []): ApiUserQueryParam
    {
        return new ApiUserQueryParam($input);
    }

    /**
     * Creates a new create parameter
     */
    public function newCreateParam(array $input = []): ApiUserCreateParam
    {
        return new ApiUserCreateParam($input);
    }

}