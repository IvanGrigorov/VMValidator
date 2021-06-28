<?php

namespace RMValidator\Attributes\PropertyAttributes\Strings;

use Attribute;
use RMValidator\Attributes\Base\IAttribute;
use RMValidator\Exceptions\InputTypeException;
use RMValidator\Exceptions\StringNotContainsException;
use RMValidator\Attributes\Base\BaseAttribute;


#[Attribute(Attribute::TARGET_PROPERTY | Attribute::TARGET_METHOD)]
final class StringNotContainsAttribute extends BaseAttribute implements IAttribute
{

    public function __construct(public string $needle, protected ?string $errorMsg = null, protected ?string $customName = null)
    {
        parent::__construct($errorMsg, $customName);
    }

    public function validate(mixed $value) : void
    {
        if (!is_string($value)) {
            throw new InputTypeException("String", gettype($value));
        }
        if (str_contains($value, $this->needle)) {
            throw new StringNotContainsException($value, $this->needle);
        }
    }
}