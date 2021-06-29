<?php

use RMValidator\Attributes\PropertyAttributes\DateTime\DateTimeAfterAttribute;
use RMValidator\Attributes\PropertyAttributes\File\FileExtensionAttribute;
use RMValidator\Attributes\PropertyAttributes\File\FileSizeAttribute;
use RMValidator\Attributes\PropertyAttributes\Numbers\RangeAttribute;
use RMValidator\Attributes\PropertyAttributes\Profile\MemoryProfileAttribute;
use RMValidator\Attributes\PropertyAttributes\Profile\TimeProfileAttribute;
use RMValidator\Attributes\PropertyAttributes\Strings\StringContainsAttribute;
use RMValidator\Options\OptionsModel;
use RMValidator\Validators\MasterValidator;

require __DIR__ . '/vendor/autoload.php';


class Test {

    #[DateTimeAfterAttribute(after: '30-06-2021')]
    public function custom() {
        return new DateTime('now');
    }

    #[FileSizeAttribute(fileSizeBiggest: 20, fileSizeLowest: 10)]
    #[FileExtensionAttribute(expected:['php'])]
    public function getFile() {
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
$test = new Test();

try {
    MasterValidator::validate($test, new OptionsModel( excludedMethods: ['getFile'], excludedProperties: ['fisadle']));
}
catch(Exception $e) {
    var_dump($e);
}
