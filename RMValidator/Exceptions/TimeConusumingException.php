<?php 

namespace RMValidator\Exceptions;

use Exception;

final class TimeConusumingException extends Exception {

    public function __construct(int $from, int $to, int $excecuted)
    {
        parent::__construct("Method excuted for: " . $excecuted . " seconds. Not in range between: " . $from . " and " . $to);
    }

}