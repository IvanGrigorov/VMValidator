<?php

namespace RMValidator\Attributes\PropertyAttributes\DateTime;

use Attribute;
use DateTime;
use RMValidator\Attributes\Base\IAttribute;
use RMValidator\Exceptions\DateTimeEqualsException;
use RMValidator\Exceptions\NotADateTimeException;
use RMValidator\Attributes\Base\BaseAttribute;


#[Attribute(Attribute::TARGET_PROPERTY | Attribute::TARGET_METHOD)]
final class DateTimeEqualsAttribute extends BaseAttribute implements IAttribute
{
    public function __construct(public string $sameDate, protected ?string $errorMsg = null, protected ?string $customName = null)
    {
        parent::__construct($errorMsg, $customName);
    }

    public function validate(mixed $value) : void
    {

        $same = new DateTime($this->sameDate);
        if (!($value instanceof DateTime)) {
            throw new NotADateTimeException();
        }
        if ($value == $same) {
            throw new DateTimeEqualsException($value, $same);
        }
    }
}