<?php 

namespace RMValidator\Exceptions;

use Exception;

final class FileExtensionException extends Exception {

    public function __construct()
    {
        parent::__construct("Not valid file: File extension not expected");
    }

}