<?php 

namespace RMValidator\Validators;

use Exception;
use ReflectionClass;
use ReflectionMethod;
use ReflectionProperty;
use RMValidator\Attributes\Base\IAttribute;
use RMValidator\Attributes\Base\IProfileAttribute;
use RMValidator\Enums\ValidationOrderEnum;
use RMValidator\Exceptions\ValidationMethodException;
use RMValidator\Exceptions\ValidationPropertyException;
use RMValidator\Options\OptionsModel;

final class MasterValidator {

    public static function validate(object $target, OptionsModel $optionsModel) {
        $className = get_class($target);
        $reflectionClass = new ReflectionClass($className);
        $methods = $reflectionClass->getMethods(ReflectionMethod::IS_PUBLIC);
        $properties = $reflectionClass->getProperties(ReflectionProperty::IS_PUBLIC);
        foreach($optionsModel->getOrderOfValidation() as $order) {
            switch($order) {
                case ValidationOrderEnum::METHODS:
                    MasterValidator::validateMethods($methods, $className, $target, $optionsModel->getExcludedMethods());
                    break;
                case ValidationOrderEnum::PROPERTIES:
                    MasterValidator::validateProperties($properties, $className, $target, $optionsModel->getExcludedProperties());
                    break;

            }
        }

    }

    private static function validateProperties(array $properties, string $className, object $target, array $excludedProperties) {
        foreach ($properties as $property) {
            $propertyName = $property->getName();
            if (in_array($propertyName, $excludedProperties)) {
                continue;
            }
            $reflectionProperty = new ReflectionProperty($className, $propertyName);
            $attributes = $reflectionProperty->getAttributes();
            foreach ($attributes as $attribute) {
                try {
                    $validationAttribute = $attribute->newInstance();
                    $validationAttribute->validate($target->$propertyName);
                }
                catch(Exception $e) {
                    $attributeNameSplitted = explode(DIRECTORY_SEPARATOR, $attribute->getName());
                    $attributeName = end($attributeNameSplitted);
                    throw new ValidationPropertyException(($validationAttribute->getCustomName()) ? $validationAttribute->getCustomName() : $propertyName,
                                                          $attributeName,
                                                          ($validationAttribute->getCustomMessage()) ? $validationAttribute->getCustomMessage() : $e->getMessage());
                }
            }
        }
    }

    private static function validateMethods(array $methods, string $className, object $target, array $excludedMethods) {
        foreach ($methods as $method) {
            $methodName = $method->getName();
            if (in_array($methodName, $excludedMethods)) {
                continue;
            }
            $reflectionMethod = new ReflectionMethod($className, $methodName);
            $attributes = $reflectionMethod->getAttributes();
            foreach ($attributes as $attribute) {
                try {
                    $validationAttribute = $attribute->newInstance();
                    if ($validationAttribute instanceof IProfileAttribute && 
                        $validationAttribute instanceof IAttribute) {
                        $validationAttribute->validate(fn() => $target->$methodName());
                    }
                    else {
                        $validationAttribute->validate($target->$methodName());
                    }
                }
                catch(Exception $e) {
                    $attributeNameSplitted = explode(DIRECTORY_SEPARATOR, $attribute->getName());
                    $attributeName = end($attributeNameSplitted);
                    throw new ValidationMethodException(($validationAttribute->getCustomName()) ? $validationAttribute->getCustomName() : $methodName,
                                                        $attributeName,
                                                        ($validationAttribute->getCustomMessage()) ? $validationAttribute->getCustomMessage() : $e->getMessage());
                }
            }
        }
    }
}