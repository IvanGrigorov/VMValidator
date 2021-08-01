<?php

namespace RMValidator\Attributes\PropertyAttributes\Global;

use Attribute;
use ReflectionClass;
use ReflectionMethod;
use RMValidator\Attributes\Base\IAttribute;
use RMValidator\Attributes\Base\BaseAttribute;
use RMValidator\Exceptions\CustomPropertyException;
use RMValidator\Exceptions\MethodDoesNotExistException;

#[Attribute(Attribute::IS_REPEATABLE | Attribute::TARGET_PROPERTY | Attribute::TARGET_METHOD | Attribute::TARGET_CLASS_CONSTANT | Attribute::TARGET_PARAMETER)]
final class CustomAttribute extends BaseAttribute implements IAttribute
{

    public function __construct(
        private string $staticClassName,
        private string $staticMethodName,
        private array $args,
        protected ?string $errorMsg = null,
        protected ?string $customName = null,
        protected ?bool $nullable = false, protected ?string $name = null)
    {
        parent::__construct($errorMsg, $customName, $nullable, $name);
    }

    public function validate(mixed $value) : void
    {
        $reflectionClass = new ReflectionClass($this->staticClassName);
        if (!$reflectionClass->hasMethod($this->staticMethodName)) {
            throw new MethodDoesNotExistException(className: $this->staticClassName, methodName: $this->staticMethodName);
        }
        $method = new ReflectionMethod($this->staticClassName, $this->staticMethodName);
        if (!$method->isStatic()) {
            throw new MethodDoesNotExistException(className: $this->staticClassName, methodName: $this->staticMethodName);
        }
        $test = $method->invokeArgs(null, [$value, ...$this->args]);
        if (!is_bool($test)) {
            throw new CustomPropertyException("Custom validation does not return boolean");
        }
        if (!$test) {
            throw new CustomPropertyException("Custom validation failed");
        }
    }
}