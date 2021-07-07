<?php

namespace RMValidator\Attributes\PropertyAttributes\Collection;

use Attribute;
use RMValidator\Exceptions\NotNullableException;
use RMValidator\Attributes\Base\BaseAttribute;
use RMValidator\Attributes\Base\IAttribute;
use RMValidator\Exceptions\AllException;
use RMValidator\Exceptions\AnyException;
use RMValidator\Exceptions\CollectionException;

#[Attribute(Attribute::IS_REPEATABLE | Attribute::TARGET_PROPERTY | Attribute::TARGET_METHOD | Attribute::TARGET_CLASS_CONSTANT | Attribute::TARGET_PARAMETER)]
final class AllAttribute extends BaseAttribute implements IAttribute {

    public function __construct(public mixed $expected = null, protected ?string $errorMsg = null, protected ?string $customName = null, protected ?bool $nullable = false)
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
        if (!is_array($value)) {
            throw new CollectionException();
        }
        if (count(array_unique($value)) > 1) {
            throw new AllException();
        }
        if (!empty($this->expected) && !in_array($this->expected, $value)) {
            throw new AnyException();
        }
    }
}