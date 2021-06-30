<?php


use PHPUnit\Framework\TestCase;
use RMValidator\Attributes\PropertyAttributes\Collection\AllAttribute;

class AllAttributeTest extends TestCase {

    /**
    * @doesNotPerformAssertions
    */
    public function testallAttribute_shouldNotThrow()
    {
        $attr = new AllAttribute('abc');
        $attr->validate(array('abc', 'abc'));
    }

    public function testallAttribute_shouldThrow()
    {
        $this->expectException(Exception::class);
        $attr = new AllAttribute('abc');
        $attr->validate(array('abc', 'abcasd'));
    }
}