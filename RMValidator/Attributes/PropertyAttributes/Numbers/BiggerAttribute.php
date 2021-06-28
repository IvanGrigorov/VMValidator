<?php

namespace RMValidator\Attributes\PropertyAttributes\Numbers;

use Attribute;
use RMValidator\Attributes\Base\IAttribute;
use RMValidator\Exceptions\BiggerException;
use RMValidator\Exceptions\NotANumberException;
use RMValidator\Attributes\Base\BaseAttribute;


#[Attribute(Attribute::TARGET_PROPERTY | Attribute::TARGET_METHOD)]
final class BiggerAttribute extends BaseAttribute implements IAttribute
{
    public function __construct(public $biggerThan, protected ?string $errorMsg = null, protected ?string $customName = null)
    {
        parent::__construct($errorMsg, $customName);
    }

    public function validate(mixed $value) : void
    {
        if (!is_numeric($value)) {
            throw new NotANumberException($value);
        }
        if (!is_numeric($this->biggerThan)) {
            throw new NotANumberException();
        }
        if ($value <= $this->biggerThan) {
            throw new BiggerException($value, $this->biggerThan);
        }
    }
}