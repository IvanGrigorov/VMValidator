<?php


use PHPUnit\Framework\TestCase;
use RMValidator\Attributes\PropertyAttributes\Global\SameAttribute;
use RMValidator\Exceptions\SameException;

class SameAttributeTest extends TestCase {

     /**
    * @doesNotPerformAssertions
    */
    public function testEqualAttribute_shouldNotThrow()
    {
        $attr = new SameAttribute(expected: 0);
        $attr->validate(0);
    }

    public function testEqualAttribute_shouldThrow()
    {
        $this->expectException(SameException::class);
        $attr = new SameAttribute(expected: 0);
        $attr->validate('0');
    }
}