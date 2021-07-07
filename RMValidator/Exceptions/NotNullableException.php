<?php 

namespace RMValidator\Exceptions;

use Exception;

final class NotNullableException extends Exception {

    public function __construct()
    {
        parent::__construct("Value is not nullable");
    }

}