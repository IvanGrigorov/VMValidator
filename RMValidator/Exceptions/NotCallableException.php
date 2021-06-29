<?php 

namespace RMValidator\Exceptions;

use Exception;

final class NotCallableException extends Exception {

    public function __construct()
    {
        parent::__construct("Value is not a method or not callable");
    }

}