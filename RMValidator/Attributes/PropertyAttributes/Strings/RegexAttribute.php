<?php

namespace RMValidator\Attributes\PropertyAttributes\Strings;

use Attribute;
use RMValidator\Exceptions\NotNullableException;
use RMValidator\Attributes\Base\IAttribute;
use RMValidator\Exceptions\InputTypeException;
use RMValidator\Exceptions\RegexException;
use RMValidator\Attributes\Base\BaseAttribute;


#[Attribute(Attribute::IS_REPEATABLE | Attribute::TARGET_PROPERTY | Attribute::TARGET_METHOD | Attribute::TARGET_CLASS_CONSTANT | Attribute::TARGET_PARAMETER)]
final class RegexAttribute extends BaseAttribute implements IAttribute
{

    public function __construct(public string $regex, protected ?string $errorMsg = null, protected ?string $customName = null, protected ?bool $nullable = false)
    {
        parent::__construct($errorMsg, $customName, $nullable);
    }

    public function validate(mixed $value) : void
    {
        if ($value === null) {
            if (!$this->checkNullable($value)) {
                throw new NotNullableException();
            }
            return;
        }
        if (!is_string($value)) {
            throw new InputTypeException("String", gettype($value));
        }
        if (!preg_match($this->regex, $value)) {
            throw new RegexException();
        }
    }
}