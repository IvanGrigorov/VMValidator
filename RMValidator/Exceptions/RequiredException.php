<?php 

namespace RMValidator\Exceptions;

use Exception;

final class RequiredException extends Exception {

    public function __construct()
    {
        parent::__construct("Property cannot be empty");
    }

}