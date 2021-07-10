<?php 

namespace RMValidator\Exceptions;

use Exception;

final class CollectionTypeException extends Exception {

    public function __construct(string $type)
    {
        parent::__construct("Collection does not include only objects of type: " . $type);
    }

}