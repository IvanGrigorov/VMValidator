<?php 

namespace RMValidator\Exceptions;

use Exception;

final class OrException extends Exception {

    public function __construct(string $propertyName)
    {
        parent::__construct("Or attribute failed for class item: ". $propertyName);
    }

}