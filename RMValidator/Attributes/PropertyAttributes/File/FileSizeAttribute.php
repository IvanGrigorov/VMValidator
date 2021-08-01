<?php

namespace RMValidator\Attributes\PropertyAttributes\File;

use Attribute;
use RMValidator\Exceptions\NotNullableException;
use RMValidator\Attributes\Base\IAttribute;
use RMValidator\Exceptions\FileSizeException;
use RMValidator\Exceptions\NotAFileException;
use RMValidator\Attributes\Base\BaseAttribute;


#[Attribute(Attribute::IS_REPEATABLE | Attribute::TARGET_PROPERTY | Attribute::TARGET_METHOD | Attribute::TARGET_CLASS_CONSTANT | Attribute::TARGET_PARAMETER)]
final class FileSizeAttribute extends BaseAttribute implements IAttribute
{
    public function __construct(public int $fileSizeLowest, public int $fileSizeBiggest, protected ?string $errorMsg = null, protected ?string $customName = null, protected ?bool $nullable = false, protected ?string $name = null)
    {
        parent::__construct($errorMsg, $customName, $nullable, $name);
    }

    public function validate(mixed $value) : void
    {
        if ($value === null) {
            if (!$this->checkNullable($value)) {
                throw new NotNullableException();
            }
            return;
        }
        if (!is_file($value)) {
            throw new NotAFileException();
        }
        if (filesize($value) < $this->fileSizeLowest || filesize($value) > $this->fileSizeBiggest) {
            throw new FileSizeException($this->fileSizeLowest, $this->fileSizeBiggest, filesize($value));
        }
    }
}