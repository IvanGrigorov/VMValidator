<?php 

namespace RMValidator\Exceptions;

use Exception;

final class AllException extends Exception {

    public function __construct()
    {
        parent::__construct("Not all elements in the array are the same");
    }

}