<?php

namespace Rapidmail\ApiClient\Service\V1\Api\Blacklist\Blacklist\Parameter;

class ParameterFactory
{

    /**
     * Creates a new query parameter
     */
    public function newQueryParam(array $input = []): BlacklistQueryParam
    {
        return new BlacklistQueryParam($input);
    }

    /**
     * Creates a new create parameter
     */
    public function newCreateParam(array $input = []): BlacklistCreateParam
    {
        return new BlacklistCreateParam($input);
    }
    /**
     * Creates a new import query parameter
     */
    public function newImportParam(array $input = []): BlacklistImportParam
    {
        return new BlacklistImportParam($this, $input);
    }

    /**
     * Creates a new import parameter file attribute
     */
    public function newImportParamFileAttr(array $input = []): BlacklistImportParamFileAttr
    {
        return new BlacklistImportParamFileAttr($input);
    }
}