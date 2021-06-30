<?php


use PHPUnit\Framework\TestCase;
use RMValidator\Attributes\PropertyAttributes\Global\EqualAttribute;
use RMValidator\Exceptions\EqualException;

class EqualAttributeTest extends TestCase {

     /**
    * @doesNotPerformAssertions
    */
    public function testEqualAttribute_shouldNotThrow()
    {
        $attr = new EqualAttribute(expected: '0');
        $attr->validate(0);
    }

    public function testEqualAttribute_shouldThrow()
    {
        $this->expectException(EqualException::class);
        $attr = new EqualAttribute(expected: '1');
        $attr->validate(0);
    }
}