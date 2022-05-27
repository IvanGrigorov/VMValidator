<?php 

namespace RMValidator\Validators;

use Exception;
use ReflectionClass;
use ReflectionClassConstant;
use ReflectionMethod;
use ReflectionProperty;
use RMValidator\Attributes\Base\IAttribute;
use RMValidator\Attributes\Base\IProfileAttribute;
use RMValidator\Callables\CallableConfig;
use RMValidator\Enums\SeverityEnum;
use RMValidator\Enums\ValidationOrderEnum;
use RMValidator\Exceptions\OrException;
use RMValidator\Exceptions\ValidationMethodException;
use RMValidator\Exceptions\ValidationPropertyException;
use RMValidator\Options\OptionsModel;

final class MasterValidator {

    public static function validate(object $target, OptionsModel $passedOptionsModel = null, CallableConfig $callback = null) {
        $optionsModel = (empty($passedOptionsModel)) ? new OptionsModel() : $passedOptionsModel;
        $failiureCallback = (!is_null($callback) && !is_null($callback->getFailiureCallable())) ? $callback->getFailiureCallable() : null;
        if (count($optionsModel->getOrAttributes()) != count(array_unique($optionsModel->getOrAttributes()))) {
            throw new Exception("There is a duplicate OR attribute, the array of the OR attributes must be unique");
        }
        $className = get_class($target);
        $reflectionClass = new ReflectionClass($className);
        $methods = $reflectionClass->getMethods();
        $properties = $reflectionClass->getProperties();
        $constants = $reflectionClass->getConstants();
        try {
            foreach($optionsModel->getOrderOfValidation() as $order) {
                switch($order) {
                    case ValidationOrderEnum::METHODS:
                        MasterValidator::validateMethods($methods, $className, $target, $optionsModel->getExcludedMethods(), $optionsModel->getOrAttributes(), $optionsModel->getGlobalSeverityLevel(), $failiureCallback);
                        break;
                    case ValidationOrderEnum::PROPERTIES:
                        MasterValidator::validateProperties($properties, $className, $target, $optionsModel->getExcludedProperties(), $optionsModel->getOrAttributes(), $optionsModel->getGlobalSeverityLevel(), $failiureCallback);
                        break;
                    case ValidationOrderEnum::CONSTANTS:
                        MasterValidator::validateConstants($constants, $className, $target, $optionsModel->getExcludedProperties(), $optionsModel->getOrAttributes(), $optionsModel->getGlobalSeverityLevel(), $failiureCallback);
                        break;
                }
            }
            if (!is_null($callback) && !is_null($callback->getSuccsessCallable())) {
                $callback->getSuccsessCallable()();
            }
        }
        catch(Exception $e) {
            throw $e;
        }
        finally {
            if (!is_null($callback) && !is_null($callback->getForcedCallable())) {
                $callback->getForcedCallable()();
            }
        }

    }

    private static function validateProperties(array $properties, string $className, object $target, array $excludedProperties, array $orAttributes, int $getGlobalSeverityLevel, ?callable $failiureCallback) {
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
                    MasterValidator::returnFailedOutput($validationAttribute, $propertyName, $attributeName, $e, false, $getGlobalSeverityLevel, $failiureCallback);
                }
            }
            if (count($orAttributesToValidate) && !MasterValidator::validateOrAttributes($orAttributesToValidate)) {
                MasterValidator::returnFailedOutput(null, $propertyName, '', null, true, $getGlobalSeverityLevel, $failiureCallback);
                break;
            }
        }
    }

    private static function validateConstants(array $constants, string $className, object $target, array $excludedProperties, array $orAttributes, int $getGlobalSeverityLevel, ?callable $failiureCallback) {
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
                    MasterValidator::returnFailedOutput($validationAttribute, $constantName, $attributeName, $e, false, $getGlobalSeverityLevel, $failiureCallback);
                }
            }
            if (count($orAttributesToValidate) && !MasterValidator::validateOrAttributes($orAttributesToValidate)) {
                MasterValidator::returnFailedOutput(null, $constantName, '', null, true, $getGlobalSeverityLevel, $failiureCallback);
                break;
            }
        }
    }

    private static function validateMethods(array $methods, string $className, object $target, array $excludedMethods, array $orAttributes, int $getGlobalSeverityLevel, ?callable $failiureCallback) {
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
                    MasterValidator::returnFailedOutput($validationAttribute, $methodName, $attributeName, $e, false, $getGlobalSeverityLevel, $failiureCallback);
                }
            }
            if (count($orAttributesToValidate) && !MasterValidator::validateOrAttributes($orAttributesToValidate)) {
                MasterValidator::returnFailedOutput(null, $methodName, '', null, true, $getGlobalSeverityLevel, $failiureCallback);
                break;
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

    private static function returnFailedOutput(?object $validationAttribute, string $vlidatedItemName, string  $attributeName, ?Exception $e, bool $isOrAttribute, int $getGlobalSeverityLevel, ?callable $failiureCallback) {
        if($isOrAttribute) {
            switch ($getGlobalSeverityLevel) {
                case SeverityEnum::NOTICE:
                case SeverityEnum::WARNING:
                    if (!is_null($failiureCallback)) {
                        $failiureCallback();
                    }
                    trigger_error("Or attribute failed for class item: ". $vlidatedItemName);
                    break;
                default:
                    if (!is_null($failiureCallback)) {
                        $failiureCallback();
                    }
                    throw new OrException($vlidatedItemName);
            }
        }
        else {
            switch ($validationAttribute->getSeverity()) {
                case SeverityEnum::NOTICE:
                case SeverityEnum::WARNING:
                    if (!is_null($failiureCallback)) {
                        $failiureCallback();
                    }
                    trigger_error("Property: " . $vlidatedItemName . " Attribute: ".  $attributeName. ' Cause:'. $e->getMessage(), $validationAttribute->getSeverity());
                    break;
                default:
                    if (!is_null($failiureCallback)) {
                        $failiureCallback();
                    }
                    throw new ValidationPropertyException(($validationAttribute->getCustomName()) ? $validationAttribute->getCustomName() : $vlidatedItemName,
                                                        $attributeName,
                                                        ($validationAttribute->getCustomMessage()) ? $validationAttribute->getCustomMessage() : $e->getMessage());
            }
        }
    }

    public static function debug(string $reflection) {
        $reflectionClass = new ReflectionClass($reflection);
        $methods = $reflectionClass->getMethods();
        $properties = $reflectionClass->getProperties();
        $constants = $reflectionClass->getConstants();

        print_r("\nPROPERTIES\n===================\n");

        foreach ($properties as $property) {
            $reflectionProperty = new ReflectionProperty($reflection, $property->getName());
            $reflectionProperty->setAccessible(true);
            $attributes = $reflectionProperty->getAttributes();
            foreach ($attributes as $attribute) {
                print_r($attribute->getName() . ':'.PHP_EOL);
                print_r($attribute->getArguments());  
           }
        }

        print_r("\nMETHODS\n===================\n");

        foreach ($methods as $method) {
            $reflectionMethod = new ReflectionMethod($reflection, $method->getName());
            $reflectionMethod->setAccessible(true);
            $attributes = $reflectionMethod->getAttributes();
            foreach ($attributes as $attribute) {
                print_r($attribute->getName() . ':'.PHP_EOL);
                print_r($attribute->getArguments());        
            }
        }

        print_r("\nCONSTANTS\n===================\n");

        foreach ($constants as $key => $constant) {
            $reflectionConstant = new ReflectionClassConstant($reflection, $key);
            $attributes = $reflectionConstant->getAttributes();
            foreach ($attributes as $attribute) {
                print_r($attribute->getName() . ':'.PHP_EOL);
                print_r($attribute->getArguments());
            }
        }
    }
}