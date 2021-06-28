<?php 

namespace RMValidator\Exceptions;

use DateTime;
use DateTimeInterface;
use Exception;

final class DateTimeEqualsException extends Exception {

    public function __construct(DateTime $dateTime, DateTime $dateTimeBefore)
    {
        parent::__construct("DateTime " . $dateTime->format(DateTimeInterface::ATOM) . " is not the same as ". $dateTimeBefore->format(DateTimeInterface::ATOM));
    }

}