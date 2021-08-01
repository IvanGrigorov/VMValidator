<?php 

namespace RMValidator\Validators;

use Exception;
use ReflectionClass;
use ReflectionClassConstant;
use ReflectionMethod;
use ReflectionProperty;
use RMValidator\Attributes\Base\IAttribute;
use RMValidator\Attributes\Base\IProfileAttribute;
use RMValidator\Enums\ValidationOrderEnum;
use RMValidator\Exceptions\OrException;
use RMValidator\Exceptions\ValidationMethodException;
use RMValidator\Exceptions\ValidationPropertyException;
use RMValidator\Options\OptionsModel;

final class MasterValidator {

    public static function validate(object $target, OptionsModel $passedOptionsModel = null) {
        $optionsModel = (empty($passedOptionsModel)) ? new OptionsModel() : $passedOptionsModel;
        $className = get_class($target);
        $reflectionClass = new ReflectionClass($className);
        $methods = $reflectionClass->getMethods();
        $properties = $reflectionClass->getProperties();
        $constants = $reflectionClass->getConstants();
        foreach($optionsModel->getOrderOfValidation() as $order) {
            switch($order) {
                case ValidationOrderEnum::METHODS:
                    MasterValidator::validateMethods($methods, $className, $target, $optionsModel->getExcludedMethods(), $passedOptionsModel->getOrAttributes());
                    break;
                case ValidationOrderEnum::PROPERTIES:
                    MasterValidator::validateProperties($properties, $className, $target, $optionsModel->getExcludedProperties(), $passedOptionsModel->getOrAttributes());
                    break;
                case ValidationOrderEnum::CONSTANTS:
                    MasterValidator::validateConstants($constants, $className, $target, $optionsModel->getExcludedProperties(), $passedOptionsModel->getOrAttributes());
                    break;

            }
        }

    }

    private static function validateProperties(array $properties, string $className, object $target, array $excludedProperties, array $orAttributes) {
        $orAttributesToValidate = [];
        foreach ($properties as $property) {
            $propertyName = $property->getName();
            if (in_array($propertyName, $excludedProperties)) {
                continue;
            }
            $reflectionProperty = new ReflectionProperty($className, $propertyName);
            $reflectionProperty->setAccessible(true);
            $attributes = $reflectionProperty->getAttributes();
            foreach ($attributes as $attribute) {
                try {
                    $validationAttribute = $attribute->newInstance();
                    if (!empty($validationAttribute->getCustomAttrName()) && 
                        in_array($validationAttribute->getCustomAttrName(), $orAttributes)) {
                        $orAttributesToValidate[] = [
                            'attr' => $validationAttribute,
                            'value' => $reflectionProperty->getValue($target)
                        ];
                    }
                    else {
                        $validationAttribute->validate($reflectionProperty->getValue($target));
                    }
                }
                catch(Exception $e) {
                    $attributeNameSplitted = explode(DIRECTORY_SEPARATOR, $attribute->getName());
                    $attributeName = end($attributeNameSplitted);
                    throw new ValidationPropertyException(($validationAttribute->getCustomName()) ? $validationAttribute->getCustomName() : $propertyName,
                                                          $attributeName,
                                                          ($validationAttribute->getCustomMessage()) ? $validationAttribute->getCustomMessage() : $e->getMessage());
                }
            }
            if (count($orAttributesToValidate) && !MasterValidator::validateOrAttributes($orAttributesToValidate)) {
                throw new OrException($propertyName);
            }
        }
    }

    private static function validateConstants(array $constants, string $className, object $target, array $excludedProperties, array $orAttributes) {
        $orAttributesToValidate = [];
        foreach ($constants as $key => $value) {
            $constantName = $key;
            if (in_array($constantName, $excludedProperties)) {
                continue;
            }
            $reflectionClassConstant = new ReflectionClassConstant($className, $constantName);
            $attributes = $reflectionClassConstant->getAttributes();
            foreach ($attributes as $attribute) {
                try {
                    $validationAttribute = $attribute->newInstance();
                    if (!empty($validationAttribute->getCustomAttrName()) && 
                        in_array($validationAttribute->getCustomAttrName(), $orAttributes)) {
                        $orAttributesToValidate[] = [
                            'attr' => $validationAttribute,
                            'value' => $value
                        ];
                    }
                    else {
                        $validationAttribute->validate($value);
                    }
                }
                catch(Exception $e) {
                    $attributeNameSplitted = explode(DIRECTORY_SEPARATOR, $attribute->getName());
                    $attributeName = end($attributeNameSplitted);
                    throw new ValidationPropertyException(($validationAttribute->getCustomName()) ? $validationAttribute->getCustomName() : $constantName,
                                                          $attributeName,
                                                          ($validationAttribute->getCustomMessage()) ? $validationAttribute->getCustomMessage() : $e->getMessage());
                }
            }
            if (count($orAttributesToValidate) && !MasterValidator::validateOrAttributes($orAttributesToValidate)) {
                throw new OrException($constantName);
            }
        }
    }

    private static function validateMethods(array $methods, string $className, object $target, array $excludedMethods, array $orAttributes) {
        $orAttributesToValidate = [];
        foreach ($methods as $method) {
            $methodName = $method->getName();
            if (in_array($methodName, $excludedMethods)) {
                continue;
            }
            $reflectionMethod = new ReflectionMethod($className, $methodName);
            $reflectionMethod->setAccessible(true);
            $attributes = $reflectionMethod->getAttributes();
            foreach ($attributes as $attribute) {
                try {
                    $validationAttribute = $attribute->newInstance();
                    if ($validationAttribute instanceof IProfileAttribute && 
                        $validationAttribute instanceof IAttribute) {
                        if (!empty($validationAttribute->getCustomAttrName()) && 
                            in_array($validationAttribute->getCustomAttrName(), $orAttributes)) {
                            $orAttributesToValidate[] = [
                                'attr' => $validationAttribute,
                                'value' => fn() => $reflectionMethod->invoke($target, null)
                            ];
                        }
                        else {
                            $validationAttribute->validate(fn() => $reflectionMethod->invoke($target, null));
                        }
                    }
                    else {
                        if (!empty($validationAttribute->getCustomAttrName()) && 
                            in_array($validationAttribute->getCustomAttrName(), $orAttributes)) {
                            $orAttributesToValidate[] = [
                                'attr' => $validationAttribute,
                                'value' => fn() => $reflectionMethod->invoke($target, null)
                            ];
                        }
                        else {
                            $validationAttribute->validate($reflectionMethod->invoke($target, null));
                        }
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
            if (count($orAttributesToValidate) && !MasterValidator::validateOrAttributes($orAttributesToValidate)) {
                throw new OrException($methodName);
            }
        }
    }

    private static function validateOrAttributes(array $orAttributes) : ?string {
        $failedValidations = 0;
        foreach($orAttributes as $attribute) {
            try {
                $attribute['attr']->validate($attribute['value']);
            }
            catch(Exception $e) {
                $failedValidations++;
            }
        }
        return $failedValidations != count($orAttributes);
    }
}