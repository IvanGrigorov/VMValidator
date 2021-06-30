<?php


use PHPUnit\Framework\TestCase;
use RMValidator\Attributes\PropertyAttributes\Profile\TimeProfileAttribute;
use RMValidator\Attributes\PropertyAttributes\Strings\RegexAttribute;
use RMValidator\Attributes\PropertyAttributes\Strings\StringContainsAttribute;
use RMValidator\Attributes\PropertyAttributes\Strings\StringLengthAttribute;
use RMValidator\Attributes\PropertyAttributes\Strings\StringNotContainsAttribute;
use RMValidator\Exceptions\RegexException;
use RMValidator\Exceptions\StringContainsException;
use RMValidator\Exceptions\StringLengthException;
use RMValidator\Exceptions\StringNotContainsException;
use RMValidator\Exceptions\TimeConusumingException;

class StringNotContainsAttributeTest extends TestCase {

     /**
    * @doesNotPerformAssertions
    */
    public function testStringNotContainsAttribute_shouldNotThrow()
    {
        $attr = new StringNotContainsAttribute(needle: 'e');
        $attr->validate('gra');
    }

    public function testStringNotContainsAttribute_shouldThrow()
    {
        $this->expectException(StringNotContainsException::class);
        $attr = new StringNotContainsAttribute(needle: 'e');
        $attr->validate('grae');
    }
}