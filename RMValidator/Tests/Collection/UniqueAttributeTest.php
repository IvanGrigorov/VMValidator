<?php


use PHPUnit\Framework\TestCase;
use RMValidator\Attributes\PropertyAttributes\Collection\UniqueAttribute;
use RMValidator\Exceptions\UniqueException;

class UniqueAttributeTest extends TestCase {

    /**
    * @doesNotPerformAssertions
    */
    public function testUniqueAttribute_shouldNotThrow()
    {
        $attr = new UniqueAttribute();
        $attr->validate(array('abc', 'abcs'));
    }

    public function testUniqueAttribute_shouldThrow()
    {
        $this->expectException(UniqueException::class);
        $attr = new UniqueAttribute();
        $attr->validate(array('abc', 'abc'));
    }
}