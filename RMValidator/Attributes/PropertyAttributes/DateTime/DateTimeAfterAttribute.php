<?php

namespace RMValidator\Attributes\PropertyAttributes\DateTime;

use Attribute;
use DateTime;
use RMValidator\Attributes\Base\IAttribute;
use RMValidator\Exceptions\DateTimeAfterException;
use RMValidator\Exceptions\NotADateTimeException;
use RMValidator\Attributes\Base\BaseAttribute;


#[Attribute(Attribute::TARGET_PROPERTY | Attribute::TARGET_METHOD)]
final class DateTimeAfterAttribute extends BaseAttribute implements IAttribute
{
    public function __construct(public string $after, protected ?string $errorMsg = null, protected ?string $customName = null)
    {
        parent::__construct($errorMsg, $customName);
    }

    public function validate(mixed $value) : void
    {
        $afterDate = new DateTime($this->after);
        if (!($value instanceof DateTime)) {
            throw new NotADateTimeException();
        }
        if ($value <= $afterDate) {
            throw new DateTimeAfterException($value, $afterDate);
        }
    }
}