<?php

namespace Rapidmail\ApiClient\Service\V1\Api\TrxEmails\TrxEmail\Parameter;

class ParameterFactory
{

    /**
     * Creates a new transaction emails query parameter
     */
    public function newQueryParam(array $input = []): TrxEmailQueryParam
    {
        return new TrxEmailQueryParam($input);
    }

}