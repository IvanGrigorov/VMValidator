<?php


use PHPUnit\Framework\TestCase;
use RMValidator\Attributes\PropertyAttributes\Numbers\RangeAttribute;
use RMValidator\Exceptions\RangeException;

class RangeAttributeTest extends TestCase {

     /**
    * @doesNotPerformAssertions
    */
    public function testRangeAttribute_shouldNotThrow()
    {
        $attr = new RangeAttribute(from: 2, to: 5);
        $attr->validate(3);
    }

    public function testRangeAttribute_shouldThrow()
    {
        $this->expectException(RangeException::class);
        $attr = new RangeAttribute(from: 2, to: 5);
        $attr->validate(1);
    }
}