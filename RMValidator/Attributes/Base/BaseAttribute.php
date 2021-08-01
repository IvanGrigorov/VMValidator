<?php

namespace RMValidator\Attributes\Base;

abstract class BaseAttribute implements IAttribute {

    public function __construct(protected ?string $errorMsg = null, protected ?string $customName = null, protected ?bool $nullable = false, protected ?string $name = null)
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


    protected function checkNullable(mixed $value) : bool {
        if ($value === null) {
            if (!$this->nullable) {
                return false;
            }
        }
        return true;
    }

}