<?php 

namespace RMValidator\Exceptions;

use Exception;

final class UniqueException extends Exception {

    public function __construct()
    {
        parent::__construct("Array is not unique");
    }

}