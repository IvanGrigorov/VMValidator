<?php

namespace RMValidator\Attributes\PropertyAttributes\Global;

use Attribute;
use RMValidator\Attributes\Base\IAttribute;
use RMValidator\Exceptions\InBetweenException;
use RMValidator\Attributes\Base\BaseAttribute;


#[Attribute(Attribute::TARGET_PROPERTY | Attribute::TARGET_METHOD | Attribute::TARGET_CLASS_CONSTANT | Attribute::TARGET_PARAMETER)]
final class InBetweenAttribute extends BaseAttribute implements IAttribute
{
    public function __construct(public array $expected, protected ?string $errorMsg = null, protected ?string $customName = null)
    {
        parent::__construct($errorMsg, $customName);
    }

    public function validate(mixed $value) : void
    {
        if (!in_array($value, $this->expected)) {
            throw new InBetweenException();
        }
    }
}