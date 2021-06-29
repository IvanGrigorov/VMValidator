<?php 

namespace RMValidator\Exceptions;

use Exception;

final class MemoryConusumingException extends Exception {

    public function __construct(int $from, int $to, int $excecuted)
    {
        parent::__construct("Method excuted with: " . $excecuted . " bytes. Not in range between: " . $from . " and " . $to);
    }

}