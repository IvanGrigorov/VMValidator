<?php 

namespace RMValidator\Exceptions;

use Exception;

final class CustomPropertyException extends Exception {

    public function __construct(string $msg)
    {
        parent::__construct($msg);
    }

}