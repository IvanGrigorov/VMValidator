<?php

namespace RMValidator\Attributes\Base;

interface IAttribute {

    public function validate(mixed $value) : void;

    public function getCustomMessage() : ?string;

    public function getCustomName() : ?string;

    public function getCustomAttrName() : ?string;

}