<?php 

namespace RMValidator\Exceptions;

use Exception;

final class LowerException extends Exception {

    public function __construct(mixed $lowerThan, int $value)
    {
        parent::__construct("Value " . $value . " is not lower than ". $value);
    }

}