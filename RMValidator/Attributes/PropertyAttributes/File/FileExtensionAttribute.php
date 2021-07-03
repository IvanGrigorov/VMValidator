<?php

namespace RMValidator\Attributes\PropertyAttributes\File;

use Attribute;
use RMValidator\Attributes\Base\IAttribute;
use RMValidator\Exceptions\FileExtensionException;
use RMValidator\Exceptions\NotAFileException;
use RMValidator\Attributes\Base\BaseAttribute;


#[Attribute(Attribute::TARGET_PROPERTY | Attribute::TARGET_METHOD | Attribute::TARGET_CLASS_CONSTANT | Attribute::TARGET_PARAMETER)]
final class FileExtensionAttribute extends BaseAttribute implements IAttribute
{
    public function __construct(public mixed $expected, protected ?string $errorMsg = null, protected ?string $customName = null)
    {
        parent::__construct($errorMsg, $customName);
    }

    public function validate(mixed $value) : void
    {
        if (!is_file($value)) {
            throw new NotAFileException();
        }
        if (!in_array(pathinfo($value)['extension'], $this->expected)) {
            throw new FileExtensionException();
        }
    }
}