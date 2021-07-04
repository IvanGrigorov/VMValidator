<?php

namespace RMValidator\Attributes\PropertyAttributes\Collection;

use Attribute;
use RMValidator\Attributes\Base\IAttribute;
use RMValidator\Exceptions\CollectionException;
use RMValidator\Exceptions\CountCollectionException;
use RMValidator\Attributes\Base\BaseAttribute;


#[Attribute(Attribute::IS_REPEATABLE | Attribute::TARGET_PROPERTY | Attribute::TARGET_METHOD | Attribute::TARGET_CLASS_CONSTANT | Attribute::TARGET_PARAMETER)]
final class CountCollectionAttribute extends BaseAttribute implements IAttribute
{
    public function __construct(public int $from, public int $to, protected ?string $errorMsg = null, protected ?string $customName = null)
    {
        parent::__construct($errorMsg, $customName);
    }

    public function validate(mixed $value) : void
    {
        if (!is_array($value)) {
            throw new CollectionException($value, $this->expected);
        }
        if (count($value) < $this->from || count($value) > $this->to) {
            throw new CountCollectionException($this->from, $this->to, count($value));
        }
    }
}