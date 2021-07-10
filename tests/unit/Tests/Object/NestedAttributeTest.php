<?php


use PHPUnit\Framework\TestCase;
use RMValidator\Attributes\PropertyAttributes\Numbers\RangeAttribute;
use RMValidator\Attributes\PropertyAttributes\Object\NestedAttribute;
use RMValidator\Exceptions\ObjectException;

class NestedAttributeTest extends TestCase {

    /**
    * @doesNotPerformAssertions
    */
    public function testNestedAttributeTest_shouldNotThrow()
    {
        $attr = new NestedAttribute();
        $attr->validate(new ValidNestedAttributeTest());
    }

    public function testNestedAttributeTest_shouldThrow()
    {
        $this->expectException(Exception::class);
        $attr = new NestedAttribute();
        $attr->validate(new InvalidNestedAttributeTest());
    }

    public function testNestedAttributeTest_shouldThrowOnInvalidObject()
    {
        $this->expectException(ObjectException::class);
        $attr = new NestedAttribute();
        $attr->validate([]);
    }

}

class InvalidNestedAttributeTest{

    #[RangeAttribute(from: 1, to: 4)]
    public int $wrongNumber = 5;
}

class ValidNestedAttributeTest {

    #[RangeAttribute(from: 1, to: 4)]
    public int $wrongNumber = 3;
}