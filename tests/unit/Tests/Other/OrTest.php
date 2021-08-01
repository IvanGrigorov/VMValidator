<?php


use PHPUnit\Framework\TestCase;
use RMValidator\Attributes\PropertyAttributes\Numbers\RangeAttribute;
use RMValidator\Attributes\PropertyAttributes\Object\NestedAttribute;
use RMValidator\Exceptions\OrException;

class OrTest extends TestCase {

     /**
    * @doesNotPerformAssertions
    */
    public function test_or_shouldNotThrow()
    {
        $attr = new NestedAttribute(orAttributes: ['vor1', 'vor2']);
        $attr->validate(new ValidOrAttributeTest());
    }

    public function test_or_shouldThrow()
    {
        $this->expectException(OrException::class);
        $attr = new NestedAttribute(orAttributes: ['ior1', 'ior2']);
        $attr->validate(new InvalidOrAttributeTest());
    }
}

class InvalidOrAttributeTest{

    #[RangeAttribute(from: 1, to: 3, name: 'ior1')]
    #[RangeAttribute(from: 1, to: 3, name: 'ior1')]
    public int $wrongNumber = 5;
}

class ValidOrAttributeTest {

    #[RangeAttribute(from: 1, to: 4, name: 'vor1')]
    #[RangeAttribute(from: 1, to: 2, name: 'vor2' )]
    public int $wrongNumber = 3;
}