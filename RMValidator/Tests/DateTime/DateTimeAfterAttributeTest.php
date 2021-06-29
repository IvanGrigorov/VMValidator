<?php


use PHPUnit\Framework\TestCase;
use RMValidator\Attributes\PropertyAttributes\DateTime\DateTimeAfterAttribute;
use RMValidator\Exceptions\DateTimeAfterException;

class DateTimeAfterAttributeTest extends TestCase {

     /**
    * @doesNotPerformAssertions
    */
    public function testDateTimeEqualsAttribute_shouldNotThrow()
    {
        $attr = new DateTimeAfterAttribute('now');
        $attr->validate(New DateTime('tomorrow'));
    }

    public function testDateTimeEqualsAttribute_shouldThrow()
    {
        $this->expectException(DateTimeAfterException::class);
        $attr = new DateTimeAfterAttribute('2021-06-05');
        $attr->validate(New DateTime('2021-05-05'));
    }
}