<?php

namespace Rapidmail\ApiClientTests\Mock;

use Rapidmail\ApiClient\Service\Parameter\GenericParameter;

class GenericParameterMock extends GenericParameter
{

    private int $knownAttributeSetterCallCount = 0;

    /**
     * @return int
     */
    public function getKnownAttributeSetterCallCount()
    {
        return $this->knownAttributeSetterCallCount;
    }

    /**
     * Returns the KnownAttributeKeys
     *
     * @return array
     */
    public function getKnownAttributeKeys(): array
    {

        return [
            'unknown_attribute',
            'known_attribute'
        ];

    }

    /**
     * @inheritDoc
     */
    public function stringifyDateTime($dateTime, string $format = 'Y-m-d H:i:s'): string
    {
        return parent::stringifyDateTime($dateTime, $format);
    }

    /**
     * @inheritDoc
     */
    public function convertBool($input)
    {
        return parent::convertBool($input);
    }

    /**
     * Proxy method for a known attribute
     *
     * @param mixed $value
     * @return static
     */
    public function setKnownAttribute($value)
    {
        $this->knownAttributeSetterCallCount++;

        $this->setAttributeRaw('known_attribute', $value);

        return $this;

    }

}