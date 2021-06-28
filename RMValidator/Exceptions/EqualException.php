<?php

namespace RMValidator\Exceptions;

use Exception;

final class EqualException extends Exception {

    public function __construct(string $expectedValue, string $actualValue)
    {
        parent::__construct("Values are not equal " . $expectedValue . " and " . $actualValue);
    }

}