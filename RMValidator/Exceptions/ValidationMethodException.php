<?php 

namespace RMValidator\Exceptions;

use Exception;
use RMValidator\Exceptions\Base\IValidationException;

final class ValidationMethodException extends Exception implements IValidationException {

    public function __construct(private string $method, private string $attribute, private string $errorMessage)
    {
        parent::__construct("There is a problem with METHOD: " . $this->method . " and ATTRRIBUTE: " . $this->attribute . ". DETAILS: " . $errorMessage);
    }

    public function getOrigMsg() : string{
        return $this->errorMessage;
    }

}