<?php 

namespace RMValidator\Exceptions;

use Exception;

final class StringNotContainsException extends Exception {

    public function __construct(string $haystack, string $needle)
    {
        parent::__construct("Value: " . $haystack . ' expects not to contain ' . $needle);
    }

}