<?php


use PHPUnit\Framework\TestCase;
use RMValidator\Attributes\PropertyAttributes\File\FileExtensionAttribute;
use RMValidator\Exceptions\FileExtensionException;

class FileExtensionAttributeTest extends TestCase {

     /**
    * @doesNotPerformAssertions
    */
    public function testFileExtensionAttribute_shouldNotThrow()
    {
        $attr = new FileExtensionAttribute(['php']);
        $attr->validate(__FILE__);
    }

    public function testFileExtensionAttribute_shouldThrow()
    {
        $this->expectException(FileExtensionException::class);
        $attr = new FileExtensionAttribute(['png']);
        $attr->validate(__FILE__);
    }
}