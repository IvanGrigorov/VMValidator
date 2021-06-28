<?php 

namespace RMValidator\Exceptions;

use Exception;

final class AnyException extends Exception {

    public function __construct()
    {
        parent::__construct("The value is not in the array");
    }

}