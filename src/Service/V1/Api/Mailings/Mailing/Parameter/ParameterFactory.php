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
     *
     * @param array $input
     * @return GenericParameter
     */
    public function newGenericParameter(array $input = []): GenericParameter
    {
        return new GenericParameter($input);
    }

    /**
     * Creates a new query parameter
     *
     * @param array $input
     * @return MailingQueryParam
     */
    public function newQueryParam(array $input = []): MailingQueryParam
    {
        return new MailingQueryParam($input);
    }

    /**
     * Creates a new create parameter
     *
     * @param array $input
     * @return MailingCreateParam
     */
    public function newCreateParam(array $input = []): MailingCreateParam
    {
        return new MailingCreateParam($this, $input);
    }

    /**
     * Creates a file attribute for use within the create parameter
     *
     * @param array $input
     * @return MailingCreateParamFileAttr
     */
    public function newMailingCreateParamFileAttr(array $input = []): MailingCreateParamFileAttr
    {
        return new MailingCreateParamFileAttr($input);
    }

    /**
     * Creates a destination attribute for use within the create parameter
     *
     * @param array $input
     * @return MailingCreateParamDestinationAttr
     */
    public function newMailingCreateParamDestinationAttr(array $input = []): MailingCreateParamDestinationAttr
    {
        return new MailingCreateParamDestinationAttr($input);
    }

}