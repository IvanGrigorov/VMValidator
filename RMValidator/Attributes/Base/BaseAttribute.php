<?php

namespace RMValidator\Attributes\Base;

abstract class BaseAttribute implements IAttribute {

    public function __construct(protected ?string $errorMsg = null, protected ?string $customName = null)
    {

    }

    public function getCustomMessage() : ?string{
        return $this->errorMsg;
    }

    public function getCustomName() : ?string{
        return $this->customName;
    }

}