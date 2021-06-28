<?php 

namespace RMValidator\Exceptions;

use Exception;

final class BiggerException extends Exception {

    public function __construct(mixed $biggerThan, int $value)
    {
        parent::__construct("Value " . $value . " is not bigger than ". $biggerThan);
    }

}