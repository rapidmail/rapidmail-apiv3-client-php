<?php

namespace Rapidmail\ApiClient\Service\V1\Api\Recipientlists\Recipientlist\Parameter;

/**
 * Parameter factory
 */
class ParameterFactory
{

    /**
     * Creates a new recipientlists create parameter
     */
    public function newCreateParam(array $input = []): RecipientlistCreateParam
    {
        return new RecipientlistCreateParam($input);
    }

    /**
     * Creates a new recipientlists activity stats parameter
     */
    public function newActivityStatsParam(array $input = []): RecipientlistActivityStatsParam
    {
        return new RecipientlistActivityStatsParam($input);
    }
}