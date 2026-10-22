<?php

namespace Rapidmail\ApiClient\Service\V1\Api\Recipients\Recipient\Parameter;

class ParameterFactory
{

    /**
     * Creates a new query parameter
     */
    public function newQueryParam(array $input = []): RecipientQueryParam
    {
        return new RecipientQueryParam($input);
    }

    /**
     * Creates a new create parameter
     */
    public function newCreateParam(array $input = []): RecipientCreateParam
    {
        return new RecipientCreateParam($input);
    }

    /**
     * Creates a new create query parameter
     */
    public function newCreateQueryParam(array $input = []): RecipientCreateQueryParam
    {
        return new RecipientCreateQueryParam($input);
    }

    /**
     * Creates a new delete query parameter
     */
    public function newDeleteQueryParam(array $input = []): RecipientDeleteQueryParam
    {
        return new RecipientDeleteQueryParam($input);
    }

    /**
     * Creates a new import parameter
     */
    public function newImportParam(array $input = []): RecipientImportParam
    {
        return new RecipientImportParam($this, $input);
    }

    /**
     * Creates a new import query parameter
     */
    public function newImportQueryParam(array $input = []): RecipientImportQueryParam
    {
        return new RecipientImportQueryParam($input);
    }

    /**
     * Creates a new import parameter file attribute
     */
    public function newImportParamFileAttr(array $input = []): RecipientImportParamFileAttr
    {
        return new RecipientImportParamFileAttr($input);
    }

}