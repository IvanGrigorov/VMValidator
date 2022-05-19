<?php

namespace RMValidator\Attributes\PropertyAttributes\Collection;

use Attribute;
use RMValidator\Exceptions\NotNullableException;
use RMValidator\Attributes\Base\IAttribute;
use RMValidator\Exceptions\CollectionException;
use RMValidator\Attributes\Base\BaseAttribute;
use RMValidator\Enums\SeverityEnum;
use RMValidator\Enums\ValidationOrderEnum;
use RMValidator\Exceptions\CollectionTypeException;
use RMValidator\Exceptions\EmptyCollectionException;
use RMValidator\Options\OptionsModel;
use RMValidator\Validators\MasterValidator;

#[Attribute(Attribute::IS_REPEATABLE | Attribute::TARGET_PROPERTY | Attribute::TARGET_METHOD | Attribute::TARGET_CLASS_CONSTANT | Attribute::TARGET_PARAMETER)]
final class NestedCollectionAttribute extends BaseAttribute implements IAttribute
{
    public function __construct(
        private string $collectionType,
        protected array $orderOValidation = [ValidationOrderEnum::PROPERTIES, ValidationOrderEnum::METHODS, ValidationOrderEnum::CONSTANTS],
        protected array $excludedMethods = [],
        protected array $excludedProperties = [],
        protected array $orAttributes = [],
        private bool $isEmptyValid = true,
        protected ?string $errorMsg = null,
        protected ?string $customName = null,
        protected ?bool $nullable = false, protected ?string $name = null, protected ?int $severity = SeverityEnum::ERROR)
    {
        parent::__construct($errorMsg, $customName, $nullable, $name, $severity);
    }

    public function validate(mixed $value) : void
    {
        if ($value === null) {
            if (!$this->checkNullable($value)) {
                throw new NotNullableException();
            }
            return;
        }
        if (!is_array($value)) {
            throw new CollectionException();
        }
        if (count($value) == 0) {
            if ($this->isEmptyValid) {
                return;
            }
            throw new EmptyCollectionException();
        }
        foreach($value as $item) {
            if (!is_object($item) || !($item instanceof $this->collectionType)) {
                throw new CollectionTypeException($this->collectionType);
            }
            MasterValidator::validate($item, new OptionsModel(
                                                orderOfValidation: $this->orderOValidation,
                                                excludedMethods: $this->excludedMethods,
                                                excludedProperties: $this->excludedProperties,
                                                orAttributes: $this->orAttributes));
        }
    }
}