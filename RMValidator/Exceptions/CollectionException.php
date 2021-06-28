<?php 

namespace RMValidator\Exceptions;

use Exception;

final class CollectionException extends Exception {

    public function __construct()
    {
        parent::__construct("Value is not an array");
    }

}