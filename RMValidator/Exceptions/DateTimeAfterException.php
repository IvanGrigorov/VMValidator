<?php 

namespace RMValidator\Exceptions;

use DateTime;
use DateTimeInterface;
use Exception;

final class DateTimeAfterException extends Exception {

    public function __construct(DateTime $dateTime, DateTime $dateTimeBefore)
    {
        parent::__construct("DateTime " . $dateTime->format(DateTimeInterface::ATOM) . " is not before than ". $dateTimeBefore->format(DateTimeInterface::ATOM));
    }

}