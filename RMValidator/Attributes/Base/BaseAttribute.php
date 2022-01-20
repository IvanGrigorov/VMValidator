<?php

namespace RMValidator\Attributes\Base;

use RMValidator\Enums\SeverityEnum;

abstract class BaseAttribute implements IAttribute {

    public function __construct(protected ?string $errorMsg = null, protected ?string $customName = null, protected ?bool $nullable = false, protected ?string $name = null, protected ?string $severity = SeverityEnum::ERROR)
    {

    }

    public function getCustomMessage() : ?string{
        return $this->errorMsg;
    }

    public function getCustomName() : ?string{
        return $this->customName;
    }

    public function getCustomAttrName() : ?string{
        return $this->name;
    }

    public function getSeverity() : ?string{
        return $this->severity;
    }


    protected function checkNullable(mixed $value) : bool {
        if ($value === null) {
            if (!$this->nullable) {
                return false;
            }
        }
        return true;
    }

}