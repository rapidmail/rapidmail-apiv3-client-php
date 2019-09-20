<?php

namespace Rapidmail\ApiClient\Service\Parameter;

use Rapidmail\ApiClient\Exception\InvalidArgumentException;

class FileAttr extends GenericParameter
{

    /**
     * @var string[]
     */
    const ALLOWED_MIME_TYPES = [];

    /**
     * @var string
     */
    const BASE64_VALIDATION_PATTERN = '~^([A-Za-z0-9+/]{4})*([A-Za-z0-9+/]{3}=|[A-Za-z0-9+/]{2}==)?$~';

    /**
     * @inheritDoc
     */
    protected function getKnownAttributeKeys()
    {
        return [
            'content',
            'type'
        ];
    }

    /**
     * Sets the file content
     *
     * @param string $content Base64 encoded content
     * @return static
     */
    public function setContent($content)
    {

        if (empty($content)) {
            throw new InvalidArgumentException('No file content provided');
        }

        if (preg_match(static::BASE64_VALIDATION_PATTERN, $content) == 0) {
            throw new InvalidArgumentException('File content must be base64 encoded');
        }

        $this->setAttributeRaw('content', $content);

        return $this;

    }

    /**
     * Sets the associated content type
     *
     * @param string $type
     * @return static
     */
    public function setType($type)
    {

        if (!in_array($type, static::ALLOWED_MIME_TYPES)) {
            throw new InvalidArgumentException(
                'Invalid mime type for file content. Must be one of: ' . implode(', ', static::ALLOWED_MIME_TYPES)
            );
        }

        $this->setAttributeRaw('type', $type);

        return $this;
    }

}