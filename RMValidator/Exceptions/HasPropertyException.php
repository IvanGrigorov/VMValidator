<?php 

namespace RMValidator\Exceptions;

use Exception;

final class HasPropertyException extends Exception {

    public function __construct(string $propertyName)
    {
        parent::__construct("The property does not exists: " . $propertyName);
    }

}