<?php

namespace RMValidator\Attributes\PropertyAttributes\DateTime;

use Attribute;
use RMValidator\Exceptions\NotNullableException;
use DateTime;
use RMValidator\Attributes\Base\IAttribute;
use RMValidator\Exceptions\DateTimeAfterException;
use RMValidator\Exceptions\NotADateTimeException;
use RMValidator\Attributes\Base\BaseAttribute;
use RMValidator\Enums\SeverityEnum;


#[Attribute(Attribute::IS_REPEATABLE | Attribute::TARGET_PROPERTY | Attribute::TARGET_METHOD | Attribute::TARGET_CLASS_CONSTANT | Attribute::TARGET_PARAMETER)]
final class DateTimeAfterAttribute extends BaseAttribute implements IAttribute
{
    public function __construct(public string $after, protected ?string $errorMsg = null, protected ?string $customName = null, protected ?bool $nullable = false, protected ?string $name = null, protected ?int $severity = SeverityEnum::ERROR)
    {
        parent::__construct($errorMsg, $customName, $nullable, $name, $severity);
    }

    public function validate(mixed $value) : void
    {
        $test= 5;
        $test= "sdad";

        if ($value === null) {
            if (!$this->checkNullable($value)) {
                throw new NotNullableException();
            }
            return;
        }
        $afterDate = new DateTime($this->after);
        if (!($value instanceof DateTime)) {
            throw new NotADateTimeException();
        }
        if ($value <= $afterDate) {
            throw new DateTimeAfterException($value, $afterDate);
        }
    }
}