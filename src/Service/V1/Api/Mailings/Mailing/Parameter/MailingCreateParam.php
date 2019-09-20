<?php

namespace Rapidmail\ApiClient\Service\V1\Api\Mailings\Mailing\Parameter;

use Rapidmail\ApiClient\Exception\InvalidArgumentException;
use Rapidmail\ApiClient\Service\Parameter\GenericParameter;

class MailingCreateParam extends GenericParameter
{

    /**
     * @var ParameterFactory
     */
    protected $parameterFactory;

    /**
     * Constructor
     *
     * @param ParameterFactory $parameterFactory
     * @param array $attributes
     */
    public function __construct(ParameterFactory $parameterFactory, array $attributes = [])
    {
        $this->parameterFactory = $parameterFactory;
        parent::__construct($attributes);
    }

    /**
     * @inheritDoc
     */
    protected function getKnownAttributeKeys()
    {
        return [
            'from_name',
            'from_email',
            'subject',
            'file',
            'destinations'
        ];
    }

    /**
     * Sets the name of mailing sender
     *
     * @param string $name
     * @return static
     */
    public function setFromName($name)
    {
        $this->setAttributeRaw('from_name', $name);

        return $this;
    }

    /**
     * Sets the email address of mailing sender. Note that the address needs to be a confirmed sender address
     *
     * @param string $email
     * @return static
     */
    public function setFromEmail($email)
    {
        $this->setAttributeRaw('from_email', $email);

        return $this;
    }

    /**
     * Sets the mailing subject
     *
     * @param string $subject
     * @return static
     */
    public function setSubject($subject)
    {
        $this->setAttributeRaw('subject', $subject);

        return $this;
    }

    /**
     * Sets the zip file containing all mailing content
     *
     * @param MailingCreateParamFileAttr|array|string|\SplFileInfo $file
     * @return static
     */
    public function setFile($file)
    {

        if ($file instanceof MailingCreateParamFileAttr) {
            $this->setAttributeRaw('file', $file);

            return $this;
        }

        if (is_array($file)) {
            $this->setAttributeRaw('file', $this->parameterFactory->newMailingCreateParamFileAttr($file));

            return $this;
        }

        $info = new \finfo(FILEINFO_MIME_TYPE);

        if ($file instanceof \SplFileInfo || is_file($file)) {

            if (!is_readable($file)) {
                throw new InvalidArgumentException("File {$file} is not readable");
            }

            $fileAttr = $this->parameterFactory->newMailingCreateParamFileAttr([
                'content' => base64_encode(file_get_contents($file)),
                'type' => $info->file($file)
            ]);

            $this->setAttributeRaw('file', $fileAttr);

            return $this;

        }

        throw new InvalidArgumentException("{$file} does not appear to be a valid file");

    }

    /**
     * Sets mailing destinations
     *
     * @return static
     * @var array[]|array[][]|MailingCreateParamDestinationAttr[] $destinations
     */
    public function setDestinations(array $destinations)
    {

        $this->setAttributeRaw(
            'destinations',
            $this->parameterFactory->newGenericParameter(
            // Suppress exception related warnings in old PHP versions https://bugs.php.net/bug.php?id=68686
                @array_map(
                    function ($destination) {

                        if ($destination instanceof MailingCreateParamDestinationAttr) {
                            return $destination;
                        }

                        if (is_numeric($destination)) {

                            // Assume a recipient list ID was provided

                            return $this->parameterFactory->newMailingCreateParamDestinationAttr()->setId($destination);

                        }

                        if (is_array($destination)) {
                            return $this->parameterFactory->newMailingCreateParamDestinationAttr($destination);
                        }

                        throw new InvalidArgumentException(
                            'Destination must be either an array or instance of MailingCreateParamDestinationAttr'
                        );

                    },
                    $destinations
                )
            )
        );

        return $this;

    }

}