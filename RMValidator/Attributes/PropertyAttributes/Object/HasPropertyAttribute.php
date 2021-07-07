<?php

namespace RMValidator\Attributes\PropertyAttributes\Object;

use Attribute;
use RMValidator\Exceptions\NotNullableException;
use RMValidator\Attributes\Base\IAttribute;
use RMValidator\Exceptions\HasPropertyException;
use RMValidator\Exceptions\NotAnObjectException;
use RMValidator\Attributes\Base\BaseAttribute;


#[Attribute(Attribute::IS_REPEATABLE | Attribute::TARGET_PROPERTY | Attribute::TARGET_METHOD | Attribute::TARGET_CLASS_CONSTANT | Attribute::TARGET_PARAMETER)]
final class HasPropertyAttribute extends BaseAttribute implements IAttribute
{
    public function __construct(public string $propertyNameExists, protected ?string $errorMsg = null, protected ?string $customName = null, protected ?bool $nullable = false)
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
        if (!is_object($value)) {
            throw new NotAnObjectException($value);
        }
        if (!property_exists($value, $this->propertyNameExists)) {
            throw new HasPropertyException($this->propertyNameExists);
        }
    }
}