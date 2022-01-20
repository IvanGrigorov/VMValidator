<?php 

namespace RMValidator\Options;

use RMValidator\Enums\SeverityEnum;
use RMValidator\Enums\ValidationOrderEnum;

final class OptionsModel {

    public function __construct(private array $orderOfValidation = [ValidationOrderEnum::PROPERTIES, ValidationOrderEnum::METHODS, ValidationOrderEnum::CONSTANTS],
                                private array $excludedMethods = [],
                                private array $excludedProperties = [],
                                private array $orAttributes = [],
                                private string $globalSeverityLevel = SeverityEnum::ERROR)
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

    public function getOrAttributes() : array {
        return $this->orAttributes;
    }

    public function getGlobalSeverityLevel() : int {
        return $this->globalSeverityLevel;
    }
}