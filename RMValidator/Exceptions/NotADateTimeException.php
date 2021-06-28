<?php 

namespace RMValidator\Exceptions;

use Exception;

final class NotADateTimeException extends Exception {

    public function __construct()
    {
        parent::__construct("Value is not a DateTime");
    }

}