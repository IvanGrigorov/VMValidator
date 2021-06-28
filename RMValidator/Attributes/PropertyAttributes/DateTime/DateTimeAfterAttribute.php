<?php

namespace RMValidator\Attributes\PropertyAttributes\File;

use Attribute;
use DateTime;
use RMValidator\Attributes\Base\IAttribute;
use RMValidator\Exceptions\DateTimeAfterException;
use RMValidator\Exceptions\NotADateTimeException;
use RMValidator\Attributes\Base\BaseAttribute;


#[Attribute(Attribute::TARGET_PROPERTY | Attribute::TARGET_METHOD)]
final class DateTimeAfterAttribute extends BaseAttribute implements IAttribute
{
    public function __construct(public DateTime $after, protected ?string $errorMsg = null, protected ?string $customName = null)
    {
        parent::__construct($errorMsg, $customName);
    }

    public function validate(mixed $value) : void
    {
        if (!($value instanceof DateTime)) {
            throw new NotADateTimeException();
        }
        if ($value <= $this->after) {
            throw new DateTimeAfterException($value, $this->after);
        }
    }
}