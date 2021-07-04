<?php

namespace RMValidator\Attributes\PropertyAttributes\Object;

use Attribute;
use RMValidator\Attributes\Base\IAttribute;
use RMValidator\Attributes\Base\BaseAttribute;
use RMValidator\Enums\ValidationOrderEnum;
use RMValidator\Options\OptionsModel;
use RMValidator\Validators\MasterValidator;

#[Attribute(Attribute::IS_REPEATABLE | Attribute::TARGET_PROPERTY | Attribute::TARGET_METHOD | Attribute::TARGET_CLASS_CONSTANT | Attribute::TARGET_PARAMETER)]
final class NestedAttribute extends BaseAttribute implements IAttribute
{
    public function __construct(
        protected array $orderOValidation = [ValidationOrderEnum::PROPERTIES, ValidationOrderEnum::METHODS, ValidationOrderEnum::CONSTANTS],
        protected array $excludedMethods = [],
        protected array $excludedProperties = [],
        protected ?string $errorMsg = null, 
        protected ?string $customName = null)
    {
        parent::__construct($errorMsg, $customName);
    }

    public function validate(mixed $value) : void
    {
        MasterValidator::validate($value, new OptionsModel($this->orderOValidation, $this->excludedMethods, $this->excludedProperties));
    }
}