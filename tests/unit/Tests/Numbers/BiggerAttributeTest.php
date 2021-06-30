<?php


use PHPUnit\Framework\TestCase;
use RMValidator\Attributes\PropertyAttributes\Numbers\BiggerAttribute;
use RMValidator\Exceptions\BiggerException;

class BiggerAttributeTest extends TestCase {

     /**
    * @doesNotPerformAssertions
    */
    public function testBiggerAttribute_shouldNotThrow()
    {
        $attr = new BiggerAttribute(biggerThan: 2);
        $attr->validate(3);
    }

    public function testBiggerAttribute_shouldThrow()
    {
        $this->expectException(BiggerException::class);
        $attr = new BiggerAttribute(biggerThan: 2);
        $attr->validate(1);
    }
}