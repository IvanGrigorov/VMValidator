<?php 

namespace RMValidator\Exceptions;

use Exception;

final class InBetweenException extends Exception {

    public function __construct()
    {
        parent::__construct("Value does not match any of the allowed properties");
    }

}