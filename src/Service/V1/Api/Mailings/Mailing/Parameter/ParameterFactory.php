<?php

namespace Rapidmail\ApiClient\Service\V1\Api\Mailings\Mailing\Parameter;

use Rapidmail\ApiClient\Service\Parameter\GenericParameter;

/**
 * Parameter factory
 */
class ParameterFactory
{

    /**
     * Creates a new generic parameter
     */
    public function newGenericParameter(array $input = []): GenericParameter
    {
        return new GenericParameter($input);
    }

    /**
     * Creates a new query parameter
     */
    public function newQueryParam(array $input = []): MailingQueryParam
    {
        return new MailingQueryParam($input);
    }

    /**
     * Creates a new create parameter
     */
    public function newCreateParam(array $input = []): MailingCreateParam
    {
        return new MailingCreateParam($this, $input);
    }

    /**
     * Creates a file attribute for use within the create parameter
     */
    public function newMailingCreateParamFileAttr(array $input = []): MailingCreateParamFileAttr
    {
        return new MailingCreateParamFileAttr($input);
    }

    /**
     * Creates a destination attribute for use within the create parameter
     */
    public function newMailingCreateParamDestinationAttr(array $input = []): MailingCreateParamDestinationAttr
    {
        return new MailingCreateParamDestinationAttr($input);
    }

}