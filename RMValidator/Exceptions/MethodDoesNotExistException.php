<?php 

namespace RMValidator\Exceptions;

use Exception;

final class MethodDoesNotExistException extends Exception {

    public function __construct(string $className, string $methodName)
    {
        parent::__construct("Class: " . $className . " does not contains static method " . $methodName);
    }

}