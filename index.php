<?php

use RMValidator\Attributes\PropertyAttributes\Collection\UniqueAttribute;
use RMValidator\Attributes\PropertyAttributes\File\FileExtensionAttribute;
use RMValidator\Attributes\PropertyAttributes\File\FileSizeAttribute;
use RMValidator\Attributes\PropertyAttributes\Numbers\RangeAttribute;
use RMValidator\Attributes\PropertyAttributes\Strings\StringContainsAttribute;
use RMValidator\Options\OptionsModel;
use RMValidator\Validators\MasterValidator;

require __DIR__ . '/vendor/autoload.php';


class Test {

    #[UniqueAttribute()]
    public function custom() {
        return ['asd', 'asdk'];
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
    MasterValidator::validate($test, new OptionsModel( excludedMethods: ['getFile'], excludedProperties: ['file']));
}
catch(Exception $e) {
    var_dump($e);
}
