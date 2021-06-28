<?php

namespace RMValidator\Attributes\PropertyAttributes\Strings;

use Attribute;
use RMValidator\Attributes\Base\IAttribute;
use RMValidator\Exceptions\InputTypeException;
use RMValidator\Exceptions\StringLengthException;
use RMValidator\Attributes\Base\BaseAttribute;


#[Attribute(Attribute::TARGET_PROPERTY | Attribute::TARGET_METHOD)]
final class StringLengthAttribute extends BaseAttribute implements IAttribute
{
    public function __construct(public int $from, public int $to, protected ?string $errorMsg = null, protected ?string $customName = null)
    {
        parent::__construct($errorMsg, $customName);
    }

    public function validate(mixed $value) : void
    {
        if (!is_string($value)) {
            throw new InputTypeException("String", gettype($value));
        }
        if (strlen($value) > $this->to || $value < strlen($value)) {
            throw new StringLengthException($this->from, $this->to, $value);
        }
    }
}