<?php

namespace RMValidator\Attributes\PropertyAttributes\Global;

use Attribute;
use RMValidator\Exceptions\NotNullableException;
use RMValidator\Attributes\Base\IAttribute;
use RMValidator\Exceptions\SameException;
use RMValidator\Attributes\Base\BaseAttribute;
use RMValidator\Enums\SeverityEnum;


#[Attribute(Attribute::IS_REPEATABLE | Attribute::TARGET_PROPERTY | Attribute::TARGET_METHOD | Attribute::TARGET_CLASS_CONSTANT | Attribute::TARGET_PARAMETER)]
final class SameAttribute extends BaseAttribute implements IAttribute
{
    public function __construct(public mixed $expected, protected ?string $errorMsg = null, protected ?string $customName = null, protected ?bool $nullable = false, protected ?string $name = null, protected ?int $severity = SeverityEnum::ERROR)
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
        if ($value !== $this->expected) {
            throw new SameException($value, $this->expected);
        }
    }
}