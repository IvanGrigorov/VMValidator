<?php 

namespace RMValidator\Exceptions;

use Exception;

final class EmptyCollectionException extends Exception {

    public function __construct()
    {
        parent::__construct("Collection cannot be empty");
    }

}