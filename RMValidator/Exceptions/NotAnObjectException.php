<?php 

namespace RMValidator\Exceptions;

use Exception;

final class NotAnObjectException extends Exception {

    public function __construct(mixed $value)
    {
        parent::__construct("Value is not an object");
    }

}