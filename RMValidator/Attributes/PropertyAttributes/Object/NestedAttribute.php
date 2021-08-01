<?php

namespace RMValidator\Attributes\PropertyAttributes\Object;

use Attribute;
use RMValidator\Exceptions\NotNullableException;
use RMValidator\Attributes\Base\IAttribute;
use RMValidator\Attributes\Base\BaseAttribute;
use RMValidator\Enums\ValidationOrderEnum;
use RMValidator\Exceptions\ObjectException;
use RMValidator\Options\OptionsModel;
use RMValidator\Validators\MasterValidator;

#[Attribute(Attribute::IS_REPEATABLE | Attribute::TARGET_PROPERTY | Attribute::TARGET_METHOD | Attribute::TARGET_CLASS_CONSTANT | Attribute::TARGET_PARAMETER)]
final class NestedAttribute extends BaseAttribute implements IAttribute
{
    public function __construct(
        protected array $orderOValidation = [ValidationOrderEnum::PROPERTIES, ValidationOrderEnum::METHODS, ValidationOrderEnum::CONSTANTS],
        protected array $excludedMethods = [],
        protected array $excludedProperties = [],
        protected array $orAttributes = [],
        protected ?string $errorMsg = null, 
        protected ?string $customName = null, protected ?bool $nullable = false, protected ?string $name = null)
    {
        parent::__construct($errorMsg, $customName, $nullable, $name);
    }

    public function validate(mixed $value) : void
    {
        if ($value === null) {
            if (!$this->checkNullable($value)) {
                throw new NotNullableException();
            }
            return;
        }
        if (!is_object($value)) {
            throw new ObjectException();
        }
        MasterValidator::validate($value, new OptionsModel(
                                                orderOfValidation: $this->orderOValidation,
                                                excludedMethods: $this->excludedMethods,
                                                excludedProperties: $this->excludedProperties,
                                                orAttributes: $this->orAttributes));
    }
}