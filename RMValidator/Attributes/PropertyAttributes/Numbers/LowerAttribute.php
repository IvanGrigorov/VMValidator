<?php

namespace RMValidator\Attributes\PropertyAttributes\Numbers;

use Attribute;
use RMValidator\Exceptions\NotNullableException;
use RMValidator\Attributes\Base\IAttribute;
use RMValidator\Exceptions\BiggerException;
use RMValidator\Exceptions\NotANumberException;
use RMValidator\Attributes\Base\BaseAttribute;
use RMValidator\Exceptions\LowerException;

#[Attribute(Attribute::IS_REPEATABLE | Attribute::TARGET_PROPERTY | Attribute::TARGET_METHOD | Attribute::TARGET_CLASS_CONSTANT | Attribute::TARGET_PARAMETER)]
final class LowerAttribute extends BaseAttribute implements IAttribute
{
    public function __construct(public float $lowerThan, protected ?string $errorMsg = null, protected ?string $customName = null, protected ?bool $nullable = false)
    {
        parent::__construct($errorMsg, $customName, $nullable);
    }

    public function validate(mixed $value) : void
    {
        if ($value == null) {
            if (!$this->checkNullable($value)) {
                throw new NotNullableException();
            }
            return;
        }
        if (!is_numeric($value)) {
            throw new NotANumberException($value);
        }
        if (!is_numeric($this->lowerThan)) {
            throw new NotANumberException();
        }
        if ($value >= $this->lowerThan) {
            throw new LowerException($value, $this->lowerThan);
        }
    }
}