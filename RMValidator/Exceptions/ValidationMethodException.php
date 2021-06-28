<?php 

namespace RMValidator\Exceptions;

use Exception;

final class ValidationMethodException extends Exception {

    public function __construct(string $method, string $attribute, string $errorMessage)
    {
        parent::__construct("There is a problem with METHOD: " . $method . " and ATTRRIBUTE: " . $attribute . ". DETAILS: " . $errorMessage);
    }

}