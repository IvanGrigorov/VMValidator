<?php


use PHPUnit\Framework\TestCase;
use RMValidator\Attributes\PropertyAttributes\Profile\TimeProfileAttribute;
use RMValidator\Attributes\PropertyAttributes\Strings\RegexAttribute;
use RMValidator\Attributes\PropertyAttributes\Strings\StringContainsAttribute;
use RMValidator\Attributes\PropertyAttributes\Strings\StringLengthAttribute;
use RMValidator\Exceptions\RegexException;
use RMValidator\Exceptions\StringContainsException;
use RMValidator\Exceptions\StringLengthException;
use RMValidator\Exceptions\TimeConusumingException;

class StringLengthAttributeTest extends TestCase {

     /**
    * @doesNotPerformAssertions
    */
    public function testStringLengthAttribute_shouldNotThrow()
    {
        $attr = new StringLengthAttribute(from:1, to: 5);
        $attr->validate('gra');
    }

    public function testStringLengthAttribute_shouldThrow()
    {
        $this->expectException(StringLengthException::class);
        $attr = new StringLengthAttribute(from:1, to: 5);
        $attr->validate('graasdasdasdsadasdas');
    }
}