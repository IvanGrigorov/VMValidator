<?php


use PHPUnit\Framework\TestCase;
use RMValidator\Attributes\PropertyAttributes\File\FileSizeAttribute;
use RMValidator\Exceptions\FileSizeException;

class FileSizeAttributeTest extends TestCase {

     /**
    * @doesNotPerformAssertions
    */
    public function testFileSizeAttribute_shouldNotThrow()
    {
        $attr = new FileSizeAttribute(fileSizeLowest: 0, fileSizeBiggest: 1000000);
        $attr->validate(__FILE__);
    }

    public function testFileSizeAttribute_shouldThrow()
    {
        $this->expectException(FileSizeException::class);
        $attr = new FileSizeAttribute(fileSizeLowest: 0, fileSizeBiggest: 10);
        $attr->validate(__FILE__);
    }
}