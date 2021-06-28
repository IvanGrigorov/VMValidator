<?php 

namespace RMValidator\Exceptions;

use Exception;

final class ValidationPropertyException extends Exception {

    public function __construct(string $property, string $attribute, string $errorMessage)
    {
        parent::__construct("There is a problem with PROPERTY: " . $property . " and ATTRRIBUTE: " . $attribute . ". DETAILS: " . $errorMessage);
    }

}