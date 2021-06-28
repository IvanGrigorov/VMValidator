<?php 

namespace RMValidator\Exceptions;

use Exception;

final class StringLengthException extends Exception {

    public function __construct(int $from, int $to, int $value)
    {
        parent::__construct("Not valid input expected " . $value . ' to be between ' . $from . ' and ' . $to. ' long');
    }

}