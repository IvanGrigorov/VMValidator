# VMValidator


![VMValidator](https://user-images.githubusercontent.com/10940601/150609303-c7566864-06ce-402b-90c8-85cfcb70e55c.jpg)

![](https://badgen.net/badge/code%20coverage/70%20%25/green?icon=codecov) ![](https://badgen.net/badge/build/passing/green?icon=status) ![](https://badgen.net/badge/icon/buymeacoffee?icon=buymeacoffee&label)

[!["Buy Me A Coffee"](https://www.buymeacoffee.com/assets/img/custom_images/yellow_img.png)](https://www.buymeacoffee.com/ivangrigorov)


Hello, this is simple attribute validation for PHP Models, based on the new features, presented in [PHP 8](https://www.php.net/releases/8.0/en.php) It works as a standalone and can be use in custom projects or in libraries like Symfony and Laravel.

Use just [three rows](https://github.com/IvanGrigorov/VMValidator/blob/2139877c4ca6ae01f60729db2d83f9c5e087096d/index.php), alogside some [attributes](https://github.com/IvanGrigorov/VMValidator/blob/2139877c4ca6ae01f60729db2d83f9c5e087096d/index.php):

# Example 

```php
<?php

use RMValidator\Attributes\PropertyAttributes\Collection\UniqueAttribute;
use RMValidator\Attributes\PropertyAttributes\File\FileExtensionAttribute;
use RMValidator\Attributes\PropertyAttributes\File\FileSizeAttribute;
use RMValidator\Attributes\PropertyAttributes\Numbers\RangeAttribute;
use RMValidator\Attributes\PropertyAttributes\Object\NestedAttribute;
use RMValidator\Attributes\PropertyAttributes\Strings\StringContainsAttribute;
use RMValidator\Enums\ValidationOrderEnum;
use RMValidator\Options\OptionsModel;
use RMValidator\Validators\MasterValidator;

require __DIR__ . '/vendor/autoload.php';


class Test 
{
    public function __construct(
        #[RangeAttribute(from:10, to:50)]
        #[RangeAttribute(from:10, to:30)]
        public int $param)
    {
        
    }

    #[RangeAttribute(from:10, to:30)]
    const propTest = 40;

    #[UniqueAttribute()]
    public function custom() {
        return ['asd', 'asdk'];
    }

    #[FileSizeAttribute(fileSizeBiggest: 20, fileSizeLowest: 10)]
    #[FileExtensionAttribute(expected:['php'])]
    private function getFile() {
        return __FILE__;
    }

    #[FileSizeAttribute(fileSizeBiggest: 20, fileSizeLowest: 10)]
    #[FileExtensionAttribute(expected:['php'])]
    public string $file = __FILE__;

    #[StringContainsAttribute(needle:"asd")]
    public string $string = "23asd";

    #[RangeAttribute(from:10, to:30)]
    public int $prop = 40;
}

class UpperTest
{
    #[NestedAttribute(excludedProperties:['param'])]
    private Test $test;

    public function __construct(Test $test) {
        $this->test = $test;
    }
}

$test = new Test(40);

try {
    MasterValidator::validate(new UpperTest($test), 
    new OptionsModel(orderOfValidation: [ValidationOrderEnum::PROPERTIES, 
                                         ValidationOrderEnum::METHODS,
                                         ValidationOrderEnum::CONSTANTS], 
                     excludedMethods: ['getFile'], 
                     excludedProperties: ['file']));
} catch(Exception $e) {
    var_dump($e);
}
```

# Installation

```bash
composer require ivangrigorov/vmvalidator
```


# Options

In what order to validate the classes (methods or properties first),  and what to exclude is directly configurable runtime [here](https://github.com/IvanGrigorov/VMValidator/blob/master/RMValidator/Options/OptionsModel.php)

# Extras

 - [x] Lots of validations
 - [x] Supports also nested object validation
 - [x] Supports also collection item types and collection item validations
 - [x] Supports also custom validations*
 - [x] Supports also or validations*
 - [x] Nullable check
 - [x] Repeatable validation attributes
 - [x] Works with private properties and methods
 - [x] Works with constructor promotion
 - [x] Memory and time profiling
 - [x] Custom error messages
 - [x] Custom property and method names for the exceptions
 - [x] Severity levels
 - [x] Debug explorer
 - [x] Callback execution*


### *The custom validation should be declared as static in a validation class
```php
class Validation 
{
    public static function validate($valueToTest, $arg1): bool 
    {
        return $valueToTest == $arg1;
    }
}
```
The method should always return boolean: ```true``` for valid input and ```false``` for invalid.

In the declaration:
```php
#[CustomAttribute(staticClassName: Validation::class, staticMethodName: 'validate', args: [2])]
```
You can pass additional arguments to use in the validation function, but the first parameter is always the value to be tested.


### *The or validation uses custom attribute names
```
    #[RangeAttribute(from:10, to:30, name: "orOne")]
    #[RangeAttribute(from:10, to:40, name: "orTwo")]
    const tttt = 40;
```

```
    MasterValidator::validate($test, new OptionsModel(orAttributes: ['orOne', 'orTwo']));

```

### *Callback execution

```$successCallable``` is executed on successful validation

```$failureCallable``` is executed on unsuccessful validation

```$forcedCallable``` is executed on successful AND unsuccessful validation




### Severity
Add option to make the failed validation throw NOTICE|WARNING|ERROR
```
    #[RangeAttribute(from:10, to:30, severity: SeverityEnum::ERROR)]

```

### Debugging
Add option to display all validations per class
```
    MasterValidator::debug(<ClassToDebug>::class);
```


# Support

 - Request a new validation
 - Give a star
 - Just say hi !
