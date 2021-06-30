<?php


use PHPUnit\Framework\TestCase;
use RMValidator\Attributes\PropertyAttributes\Global\RequiredAttribute;
use RMValidator\Exceptions\RequiredException;

class RequiredAttributeTest extends TestCase {

     /**
    * @doesNotPerformAssertions
    */
    public function testRequiredAttribute_shouldNotThrow()
    {
        $attr = new RequiredAttribute();
        $attr->validate(1);
    }

    public function testRequiredAttribute_shouldThrow()
    {
        $this->expectException(RequiredException::class);
        $attr = new RequiredAttribute();
        $attr->validate(0);
    }
}