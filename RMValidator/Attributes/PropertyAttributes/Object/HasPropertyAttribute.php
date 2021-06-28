<?php

namespace RMValidator\Attributes\PropertyAttributes\Object;

use Attribute;
use RMValidator\Attributes\Base\IAttribute;
use RMValidator\Exceptions\HasPropertyException;
use RMValidator\Exceptions\NotAnObjectException;
use RMValidator\Attributes\Base\BaseAttribute;


#[Attribute(Attribute::TARGET_PROPERTY | Attribute::TARGET_METHOD)]
final class HasPropertyAttribute extends BaseAttribute implements IAttribute
{
    public function __construct(public string $propertyNameExists, protected ?string $errorMsg = null, protected ?string $customName = null)
    {
        parent::__construct($errorMsg, $customName);
    }
    public function validate(mixed $value) : void
    {
        if (!is_object($value)) {
            throw new NotAnObjectException($value);
        }
        if (property_exists($value, $this->propertyNameExists)) {
            throw new HasPropertyException($this->propertyNameExists);
        }
    }
}