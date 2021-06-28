<?php

namespace RMValidator\Attributes\PropertyAttributes\Numbers;

use Attribute;
use RMValidator\Attributes\Base\IAttribute;
use RMValidator\Exceptions\InputTypeException;
use RMValidator\Exceptions\RangeException;
use RMValidator\Attributes\Base\BaseAttribute;


#[Attribute(Attribute::TARGET_PROPERTY | Attribute::TARGET_METHOD)]
final class RangeAttribute extends BaseAttribute implements IAttribute
{
    public function __construct(public float $from, public float $to, protected ?string $errorMsg = null, protected ?string $customName = null)
    {
        parent::__construct($errorMsg, $customName);
    }

    public function validate(mixed $value) : void
    {
        if (!is_int($value)) {
            throw new InputTypeException("Int", gettype($value));
        }
        if ($value > $this->to || $value < $this->from) {
            throw new RangeException($this->from, $this->to, $value);
        }
    }
}