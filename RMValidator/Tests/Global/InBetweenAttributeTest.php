<?php


use PHPUnit\Framework\TestCase;
use RMValidator\Attributes\PropertyAttributes\Global\InBetweenAttribute;
use RMValidator\Exceptions\InBetweenException;

class InBetweenAttributeTest extends TestCase {

     /**
    * @doesNotPerformAssertions
    */
    public function testInBetweenAttribute_shouldNotThrow()
    {
        $attr = new InBetweenAttribute(expected: array(1,2,3));
        $attr->validate(1);
    }

    public function testInBetweenAttribute_shouldThrow()
    {
        $this->expectException(InBetweenException::class);
        $attr = new InBetweenAttribute(expected: array(1,2,3));
        $attr->validate(10);
    }
}