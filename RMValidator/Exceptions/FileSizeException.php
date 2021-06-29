<?php 

namespace RMValidator\Exceptions;

use Exception;

final class FileSizeException extends Exception {

    public function __construct(int $fileSizeLowest, int $fileSizeBiggest, int $fileSize)
    {
        parent::__construct("Not valid file: Filesize expected: " . $fileSize . ' to be between ' . $fileSizeLowest . ' and ' . $fileSizeBiggest);
    }

}