<?php


use PHPUnit\Framework\TestCase;
use RMValidator\Attributes\PropertyAttributes\DateTime\DateTimeBeforeAttribute;
use RMValidator\Exceptions\DateTimeBeforeException;

class DateTimeBeforeAttributeTest extends TestCase {

    /**
    * @doesNotPerformAssertions
    */
    public function testDateTimeBeforeAttribute_shouldNotThrow()
    {
        $attr = new DateTimeBeforeAttribute('2021-06-05');
        $attr->validate(New DateTime('2021-05-05'));
    }

    public function testDateTimeBeforeAttribute_shouldThrow()
    {
        $this->expectException(DateTimeBeforeException::class);
        $attr = new DateTimeBeforeAttribute('2021-06-05');
        $attr->validate(New DateTime('2021-07-05'));
    }
}