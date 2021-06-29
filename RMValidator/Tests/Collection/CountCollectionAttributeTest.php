<?php


use PHPUnit\Framework\TestCase;
use RMValidator\Attributes\PropertyAttributes\Collection\CountCollectionAttribute;
use RMValidator\Exceptions\CountCollectionException;

class CountCollectionAttributeTest extends TestCase {

    /**
    * @doesNotPerformAssertions
    */
    public function testCountCollectionAttribute_shouldNotThrow()
    {
        $attr = new CountCollectionAttribute(from: 1, to: 3);
        $attr->validate(array('abc', 'abc'));
    }

    public function testCountCollectionAttribute_shouldThrow()
    {
        $this->expectException(CountCollectionException::class);
        $attr = new CountCollectionAttribute(from: 1, to: 2);
        $attr->validate(array('abc', 'abc', 'abc'));
    }
}