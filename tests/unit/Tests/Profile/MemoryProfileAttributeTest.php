<?php


use PHPUnit\Framework\TestCase;
use RMValidator\Attributes\PropertyAttributes\Profile\MemoryProfileAttribute;
use RMValidator\Exceptions\MemoryConusumingException;

class MemoryProfileAttributeTest extends TestCase {

     /**
    * @doesNotPerformAssertions
    */
    public function testMemoryProfileAttribute_shouldNotThrow()
    {
        $attr = new MemoryProfileAttribute(memFrom: 0, memTo: 1000000000);
        $attr->validate(fn() => "yes");
    }

    public function testMemoryProfileAttribute_shouldThrow()
    {
        $this->expectException(MemoryConusumingException::class);
        $attr = new MemoryProfileAttribute(memFrom: 0, memTo: 100);
        $fn = function() {
            for($i = 0; $i < 1000000; $i++) {
                continue;
            }
        };
        $attr->validate($fn);
    }
}