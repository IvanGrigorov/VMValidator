<?php

namespace RMValidator\Attributes\PropertyAttributes\File;

use Attribute;
use RMValidator\Attributes\Base\IAttribute;
use RMValidator\Exceptions\FileSizeException;
use RMValidator\Exceptions\NotAFileException;
use RMValidator\Attributes\Base\BaseAttribute;


#[Attribute(Attribute::TARGET_PROPERTY | Attribute::TARGET_METHOD)]
final class FileSizeAttribute extends BaseAttribute implements IAttribute
{
    public function __construct(public int $fileSizeLowest, public int $fileSizeBiggest, protected ?string $errorMsg = null, protected ?string $customName = null)
    {
        parent::__construct($errorMsg, $customName);
    }

    public function validate(mixed $value) : void
    {
        if (!is_file($value)) {
            throw new NotAFileException();
        }
        if (filesize($value) < $this->fileSizeLowest || filesize($value) > $this->fileSizeBiggest) {
            throw new FileSizeException($this->fileSizeLowest, $this->fileSizeBiggest, filesize($value));
        }
    }
}