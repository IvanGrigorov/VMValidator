<?php

namespace RMValidator\Exceptions;

use Exception;

final class SameException extends Exception {

    public function __construct(string $expectedValue, string $actualValue)
    {
        parent::__construct("Values are not the same " . $expectedValue . " and " . $actualValue);
    }

}