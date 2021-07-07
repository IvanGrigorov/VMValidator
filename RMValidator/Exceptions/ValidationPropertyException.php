<?php

namespace RMValidator\Exceptions;
use RMValidator\Exceptions\Base\IValidationException;

use Exception;

final class ValidationPropertyException extends Exception implements IValidationException {

        public function __construct(private string $property, private string $attribute, private string $errorMessage)
    {
        parent::__construct("There is a problem with PROPERTY: " . $this->property . " and ATTRRIBUTE: " . $this->attribute . ". DETAILS: " . $errorMessage);
    }

    public function getOrigMsg() : string{
        return $this->errorMessage;
    }

}