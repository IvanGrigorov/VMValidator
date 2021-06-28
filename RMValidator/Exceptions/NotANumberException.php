<?php 

namespace RMValidator\Exceptions;

use Exception;

final class NotANumberException extends Exception {

    public function __construct()
    {
        parent::__construct("Value is not a number ");
    }

}