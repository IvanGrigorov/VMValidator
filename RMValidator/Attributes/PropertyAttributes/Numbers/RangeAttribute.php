<?php

namespace RMValidator\Attributes\PropertyAttributes\Numbers;

use Attribute;
use RMValidator\Exceptions\NotNullableException;
use RMValidator\Attributes\Base\IAttribute;
use RMValidator\Exceptions\InputTypeException;
use RMValidator\Exceptions\RangeException;
use RMValidator\Attributes\Base\BaseAttribute;
use RMValidator\Enums\SeverityEnum;


#[Attribute(Attribute::IS_REPEATABLE | Attribute::TARGET_PROPERTY | Attribute::TARGET_METHOD | Attribute::TARGET_CLASS_CONSTANT | Attribute::TARGET_PARAMETER)]
final class RangeAttribute extends BaseAttribute implements IAttribute
{
    public function __construct(public float $from, public float $to, protected ?string $errorMsg = null, protected ?string $customName = null, protected ?bool $nullable = false, protected ?string $name = null, protected ?int $severity = SeverityEnum::ERROR)
    {
        parent::__construct($errorMsg, $customName, $nullable, $name, $severity);
    }

    public function validate(mixed $value) : void
    {
        if ($value === null) {
            if (!$this->checkNullable($value)) {
                throw new NotNullableException();
            }
            return;
        }
        if (!is_int($value)) {
            throw new InputTypeException("Int", gettype($value));
        }
        if ($value > $this->to || $value < $this->from) {
            throw new RangeException($this->from, $this->to, $value);
        }
    }
}