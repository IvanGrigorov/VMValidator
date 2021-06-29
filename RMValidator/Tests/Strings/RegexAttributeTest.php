<?php


use PHPUnit\Framework\TestCase;
use RMValidator\Attributes\PropertyAttributes\Profile\TimeProfileAttribute;
use RMValidator\Attributes\PropertyAttributes\Strings\RegexAttribute;
use RMValidator\Exceptions\RegexException;
use RMValidator\Exceptions\TimeConusumingException;

class RegexAttributeTest extends TestCase {

     /**
    * @doesNotPerformAssertions
    */
    public function testRegexAttribute_shouldNotThrow()
    {
        $attr = new RegexAttribute(regex: '/g+/');
        $attr->validate('graad');
    }

    public function testRegexAttribute_shouldThrow()
    {
        $this->expectException(RegexException::class);
        $attr = new RegexAttribute(regex: '/g+/');
        $attr->validate('aad');
    }
}