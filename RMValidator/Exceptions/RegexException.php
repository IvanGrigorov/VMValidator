<?php 

namespace RMValidator\Exceptions;

use Exception;

final class RegexException extends Exception {

    public function __construct()
    {
        parent::__construct("Value does not match the regex");
    }

}