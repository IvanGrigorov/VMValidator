<?php

namespace RMValidator\Attributes\PropertyAttributes\DateTime;

use Attribute;
use RMValidator\Exceptions\NotNullableException;
use DateTime;
use RMValidator\Attributes\Base\IAttribute;
use RMValidator\Exceptions\DateTimeEqualsException;
use RMValidator\Exceptions\NotADateTimeException;
use RMValidator\Attributes\Base\BaseAttribute;


#[Attribute(Attribute::IS_REPEATABLE | Attribute::TARGET_PROPERTY | Attribute::TARGET_METHOD | Attribute::TARGET_CLASS_CONSTANT | Attribute::TARGET_PARAMETER)]
final class DateTimeEqualsAttribute extends BaseAttribute implements IAttribute
{
    public function __construct(public string $sameDate, protected ?string $errorMsg = null, protected ?string $customName = null, protected ?bool $nullable = false, protected ?string $name = null)
    {
        parent::__construct($errorMsg, $customName, $nullable, $name);
    }

    public function validate(mixed $value) : void
    {
        if ($value === null) {
            if (!$this->checkNullable($value)) {
                throw new NotNullableException();
            }
            return;
        }

        $same = new DateTime($this->sameDate);
        if (!($value instanceof DateTime)) {
            throw new NotADateTimeException();
        }
        if ($value != $same) {
            throw new DateTimeEqualsException($value, $same);
        }
    }
}