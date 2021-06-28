<?php 

namespace RMValidator\Options;

use RMValidator\Enums\ValidationOrderEnum;

final class OptionsModel {

    public function __construct(private array $orderOfValidation = [ValidationOrderEnum::METHODS, ValidationOrderEnum::PROPERTIES],
                                private array $excludedMethods = [],
                                private array $excludedProperties = [],)
    {}

    public function getOrderOfValidation() : array {
        return $this->orderOfValidation;
    }

    public function getExcludedMethods() : array {
        return $this->excludedMethods;
    }

    public function getExcludedProperties() : array {
        return $this->excludedProperties;
    }
}