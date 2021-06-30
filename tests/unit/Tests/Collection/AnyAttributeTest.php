<?php


use PHPUnit\Framework\TestCase;
use RMValidator\Attributes\PropertyAttributes\Collection\AnyAttribute;
use RMValidator\Exceptions\AnyException;

class AnyAttributeTest extends TestCase {

    /**
    * @doesNotPerformAssertions
    */
    public function testAnyAttributeTest_shouldNotThrow()
    {
        $attr = new AnyAttribute('abc');
        $attr->validate(array('abc', 'abcasdasd'));
    }

    public function testAnyAttributeTest_shouldThrow()
    {
        $this->expectException(AnyException::class);
        $attr = new AnyAttribute('abc');
        $attr->validate(array('aasdsadsabc', 'abcasd'));
    }
}