<?php

namespace Rapidmail\ApiClient\Service\Parameter;

use Rapidmail\ApiClient\Exception\InvalidArgumentException;

/**
 *  Generic method parameter
 */
class GenericParameter implements ParameterInterface
{

    private \ArrayObject $attributeStore;

    /**
     * Constructor
     */
    public function __construct(array $attributes = [])
    {

        $this->attributeStore = new \ArrayObject();

        foreach ($attributes as $attributeKey => $attributeValue) {
            $this->setAttribute($attributeKey, $attributeValue);
        }

    }

    /**
     * Sets a single attribute
     *
     * @param mixed $value
     * @return static
     */
    public function setAttribute(string $key, $value)
    {

        $keys = $this->getKnownAttributeKeys();

        if (in_array($key, $keys)) {

            $setterMethod = 'set' . str_replace('_', '', ucwords($key, '_'));

            if (method_exists($this, $setterMethod)) {
                $this->{$setterMethod}($value);

                return $this;
            }

        }

        $this->setAttributeRaw($key, $value);

        return $this;

    }

    /**
     * Sets a single attribute
     *
     * @param mixed $value
     */
    protected function setAttributeRaw(string $key, $value): void
    {
        $this->attributeStore->offsetSet($key, $value);
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return array_map(
            fn($value) => $value instanceof ParameterInterface ? $value->toArray() : $value,
            $this->attributeStore->getArrayCopy()
        );
    }

    /**
     * A list of known attribute keys that will be mapped to an appropriate setter method
     *
     * @return string[]
     */
    protected function getKnownAttributeKeys(): array
    {
        return [];
    }

    /**
     * Prepare date time string
     *
     * @param string|\DateTimeInterface $dateTime
     */
    protected function stringifyDateTime($dateTime, string $format = 'Y-m-d H:i:s'): string
    {

        if ($dateTime instanceof \DateTimeInterface) {
            return $dateTime->format($format);
        }

        if (!is_string($dateTime)) {

            throw new InvalidArgumentException(
                'Date time must be either a string or an instance of \DateTimeInterface'
            );

        }

        return $dateTime;

    }

    /**
     * @param mixed
     * @return mixed
     */
    protected function convertBool($input)
    {

        if (!in_array($input, [false, true, 0, 1, '0', '1'], true)) {
            return $input;
        }

        return $input ? 'yes' : 'no';

    }

}