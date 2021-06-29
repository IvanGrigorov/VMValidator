<?php

namespace RMValidator\Attributes\PropertyAttributes\Numbers;

use Attribute;
use RMValidator\Attributes\Base\IAttribute;
use RMValidator\Exceptions\BiggerException;
use RMValidator\Exceptions\NotANumberException;
use RMValidator\Attributes\Base\BaseAttribute;
use RMValidator\Exceptions\LowerException;

#[Attribute(Attribute::TARGET_PROPERTY | Attribute::TARGET_METHOD)]
final class LowerAttribute extends BaseAttribute implements IAttribute
{
    public function __construct(public float $lowerThan, protected ?string $errorMsg = null, protected ?string $customName = null)
    {
        parent::__construct($errorMsg, $customName);
    }

    public function validate(mixed $value) : void
    {
        if (!is_numeric($value)) {
            throw new NotANumberException($value);
        }
        if (!is_numeric($this->lowerThan)) {
            throw new NotANumberException();
        }
        if ($value >= $this->lowerThan) {
            throw new LowerException($value, $this->lowerThan);
        }
    }
}