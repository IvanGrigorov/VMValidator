<?php


use PHPUnit\Framework\TestCase;
use RMValidator\Attributes\PropertyAttributes\Profile\TimeProfileAttribute;
use RMValidator\Attributes\PropertyAttributes\Strings\RegexAttribute;
use RMValidator\Attributes\PropertyAttributes\Strings\StringContainsAttribute;
use RMValidator\Exceptions\RegexException;
use RMValidator\Exceptions\StringContainsException;
use RMValidator\Exceptions\TimeConusumingException;

class StringContainsAttributeTest extends TestCase {

     /**
    * @doesNotPerformAssertions
    */
    public function testStringContainsAttribute_shouldNotThrow()
    {
        $attr = new StringContainsAttribute(needle: 'g');
        $attr->validate('graad');
    }

    public function testStringContainsAttribute_shouldThrow()
    {
        $this->expectException(StringContainsException::class);
        $attr = new StringContainsAttribute(needle: 'g');
        $attr->validate('raad');
    }
}