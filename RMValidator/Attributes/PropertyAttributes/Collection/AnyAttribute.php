<?php

namespace RMValidator\Attributes\PropertyAttributes\Collection;

use Attribute;
use RMValidator\Attributes\Base\IAttribute;
use RMValidator\Exceptions\AnyException;
use RMValidator\Exceptions\CollectionException;
use RMValidator\Attributes\Base\BaseAttribute;

#[Attribute(Attribute::TARGET_PROPERTY | Attribute::TARGET_METHOD | Attribute::TARGET_CLASS_CONSTANT | Attribute::TARGET_PARAMETER)]
final class AnyAttribute extends BaseAttribute implements IAttribute {

    public function __construct(public mixed $expected, protected ?string $errorMsg = null, protected ?string $customName = null)
    {
        parent::__construct($errorMsg, $customName);
    }

    public function validate(mixed $value) : void
    {
        if (!is_array($value)) {
            throw new CollectionException();
        }
        if (!in_array($this->expected, $value)) {
            throw new AnyException();
        }
    }
}