<?php 

namespace RMValidator\Exceptions;

use Exception;

final class ObjectException extends Exception {

    public function __construct()
    {
        parent::__construct("Value is not an object");
    }

}