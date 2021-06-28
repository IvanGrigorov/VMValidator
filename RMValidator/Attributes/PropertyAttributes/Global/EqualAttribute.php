<?php

namespace RMValidator\Attributes\PropertyAttributes\Global;

use Attribute;
use RMValidator\Attributes\Base\IAttribute;
use RMValidator\Exceptions\EqualException;
use RMValidator\Attributes\Base\BaseAttribute;


#[Attribute(Attribute::TARGET_PROPERTY | Attribute::TARGET_METHOD)]
final class EqualAttribute extends BaseAttribute implements IAttribute
{
    public function __construct(public mixed $expected, protected ?string $errorMsg = null, protected ?string $customName = null)
    {
        parent::__construct($errorMsg, $customName);
    }

    public function validate(mixed $value) : void
    {
        if ($value != $this->expected) {
            throw new EqualException($value, $this->expected);
        }
    }
}