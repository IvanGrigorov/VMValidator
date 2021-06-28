<?php 

namespace RMValidator\Exceptions;

use Exception;

final class StringContainsException extends Exception {

    public function __construct(string $haystack, string $needle)
    {
        parent::__construct("Value: " . $haystack . ' expects to contain ' . $needle);
    }

}