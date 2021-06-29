<?php

namespace RMValidator\Attributes\PropertyAttributes\Profile;

use Attribute;
use RMValidator\Attributes\Base\BaseAttribute;
use RMValidator\Attributes\Base\IAttribute;
use RMValidator\Attributes\Base\IProfileAttribute;
use RMValidator\Exceptions\NotCallableException;
use RMValidator\Exceptions\TimeConusumingException;

#[Attribute(Attribute::TARGET_PROPERTY | Attribute::TARGET_METHOD)]
final class TimeProfileAttribute extends BaseAttribute implements IAttribute, IProfileAttribute {

    public function __construct(public int $timeFrom, public int $timeTo, protected ?string $errorMsg = null, protected ?string $customName = null)
    {
        parent::__construct($errorMsg, $customName);
    }

    public function validate(mixed $value) : void
    {
        if (!is_callable($value)) {
            throw new NotCallableException();
        }
        $startTime = microtime(true);
        $value();
        $endTime = microtime(true);
        $executionTime = $endTime - $startTime;
        if ($executionTime > $this->timeTo || $executionTime < $this->timeFrom) {
            throw new TimeConusumingException($this->timeFrom, $this->timeTo, $executionTime);
        }
    }
}