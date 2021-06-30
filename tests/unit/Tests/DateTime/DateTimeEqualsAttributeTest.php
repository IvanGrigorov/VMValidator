<?php


use PHPUnit\Framework\TestCase;
use RMValidator\Attributes\PropertyAttributes\DateTime\DateTimeEqualsAttribute;
use RMValidator\Exceptions\DateTimeEqualsException;

class DateTimeEqualsAttributeTest extends TestCase {

     /**
    * @doesNotPerformAssertions
    */
    public function testDateTimeEqualsAttribute_shouldNotThrow()
    {
        $attr = new DateTimeEqualsAttribute('2021-06-05');
        $attr->validate(New DateTime('2021-06-05'));
    }

    public function testDateTimeEqualsAttribute_shouldThrow()
    {
        $this->expectException(DateTimeEqualsException::class);
        $attr = new DateTimeEqualsAttribute('2021-06-05');
        $attr->validate(New DateTime('2021-05-05'));
    }
}