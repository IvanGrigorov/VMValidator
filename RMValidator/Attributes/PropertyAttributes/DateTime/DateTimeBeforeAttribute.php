<?php

namespace RMValidator\Attributes\PropertyAttributes\DateTime;

use Attribute;
use RMValidator\Exceptions\NotNullableException;
use DateTime;
use RMValidator\Attributes\Base\IAttribute;
use RMValidator\Exceptions\DateTimeBeforeException;
use RMValidator\Exceptions\NotADateTimeException;
use RMValidator\Attributes\Base\BaseAttribute;
use RMValidator\Enums\SeverityEnum;


#[Attribute(Attribute::IS_REPEATABLE | Attribute::TARGET_PROPERTY | Attribute::TARGET_METHOD | Attribute::TARGET_CLASS_CONSTANT | Attribute::TARGET_PARAMETER)]
final class DateTimeBeforeAttribute extends BaseAttribute implements IAttribute
{
    public function __construct(public string $before, protected ?string $errorMsg = null, protected ?string $customName = null, protected ?bool $nullable = false, protected ?string $name = null, protected ?int $severity = SeverityEnum::ERROR)
    {
        parent::__construct($errorMsg, $customName, $nullable, $name, $severity);
    }

    public function validate(mixed $value) : void
    {
        if ($value === null) {
            if (!$this->checkNullable($value)) {
                throw new NotNullableException();
            }
            return;
        }
        $beforeDate = new DateTime($this->before);
        if (!($value instanceof DateTime)) {
            throw new NotADateTimeException();
        }
        if ($value >= $beforeDate) {
            throw new DateTimeBeforeException($value, $beforeDate);
        }
    }
}