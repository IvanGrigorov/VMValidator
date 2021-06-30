<?php


use PHPUnit\Framework\TestCase;
use RMValidator\Attributes\PropertyAttributes\Profile\TimeProfileAttribute;
use RMValidator\Exceptions\TimeConusumingException;

class TimeProfileAttributeTest extends TestCase {

     /**
    * @doesNotPerformAssertions
    */
    public function testTimeProfileAttribute_shouldNotThrow()
    {
        $attr = new TimeProfileAttribute(timeFrom: 0, timeTo: 1000000);
        $attr->validate(fn() => "yes");
    }

    public function testTimeProfileAttribute_shouldThrow()
    {
        $this->expectException(TimeConusumingException::class);
        $attr = new TimeProfileAttribute(timeFrom: 0, timeTo: 5);
        $attr->validate(fn() => sleep(6));
    }
}