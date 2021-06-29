<?php


use PHPUnit\Framework\TestCase;
use RMValidator\Attributes\PropertyAttributes\Numbers\LowerAttribute;
use RMValidator\Exceptions\LowerException;

class LowerAttributeTest extends TestCase {

     /**
    * @doesNotPerformAssertions
    */
    public function testLowerAttribute_shouldNotThrow()
    {
        $attr = new LowerAttribute(lowerThan: 2);
        $attr->validate(1);
    }

    public function testLowerAttribute_shouldThrow()
    {
        $this->expectException(LowerException::class);
        $attr = new LowerAttribute(lowerThan: 2);
        $attr->validate(2);
    }
}