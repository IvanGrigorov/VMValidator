<?php

namespace RMValidator\Attributes\PropertyAttributes\Profile;

use Attribute;
use RMValidator\Attributes\Base\BaseAttribute;
use RMValidator\Attributes\Base\IAttribute;
use RMValidator\Attributes\Base\IProfileAttribute;
use RMValidator\Exceptions\MemoryConusumingException;
use RMValidator\Exceptions\NotCallableException;
use RMValidator\Exceptions\TimeConusumingException;

#[Attribute(Attribute::TARGET_PROPERTY | Attribute::TARGET_METHOD)]
final class MemoryProfileAttribute extends BaseAttribute implements IAttribute, IProfileAttribute {

    public function __construct(public int $memFrom, public int $memTo, protected ?string $errorMsg = null, protected ?string $customName = null)
    {
        parent::__construct($errorMsg, $customName);
    }

    public function validate(mixed $value) : void
    {
        if (!is_callable($value)) {
            throw new NotCallableException();
        }
        $startMemory = memory_get_usage();
        $value();
        $endMemory = memory_get_peak_usage();
        $executionMemory = $endMemory - $startMemory;
        if ($executionMemory > $this->memTo || $executionMemory < $this->memFrom) {
            throw new MemoryConusumingException($this->memFrom, $this->memTo, $executionMemory);
        }
    }
}