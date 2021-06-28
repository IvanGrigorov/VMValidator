<?php

namespace RMValidator\Attributes\PropertyAttributes\File;

use Attribute;
use DateTime;
use RMValidator\Attributes\Base\IAttribute;
use RMValidator\Exceptions\DateTimeEqualsException;
use RMValidator\Exceptions\NotADateTimeException;
use RMValidator\Attributes\Base\BaseAttribute;


#[Attribute(Attribute::TARGET_PROPERTY | Attribute::TARGET_METHOD)]
final class DateTimeEqualsAttribute extends BaseAttribute implements IAttribute
{
    public function __construct(public DateTime $sameDate, protected ?string $errorMsg = null, protected ?string $customName = null)
    {
        parent::__construct($errorMsg, $customName);
    }

    public function validate(mixed $value) : void
    {
        if (!($value instanceof DateTime)) {
            throw new NotADateTimeException();
        }
        if ($value == $this->sameDate) {
            throw new DateTimeEqualsException($value, $this->sameDate);
        }
    }
}