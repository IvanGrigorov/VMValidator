<?php 

namespace RMValidator\Exceptions;

use Exception;

final class CountCollectionException extends Exception {

    public function __construct(int $from, int $to, int $count)
    {
        parent::__construct("Array count: " . $count. " is not between: " . $from . " and " . $to);
    }

}