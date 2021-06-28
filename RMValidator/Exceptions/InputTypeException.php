<?php 

namespace RMValidator\Exceptions;

use Exception;

final class InputTypeException extends Exception {

    public function __construct(string $expectedType, string $actualType)
    {
        parent::__construct("Not valid input expected " . $expectedType . " got " . $actualType);
    }

}