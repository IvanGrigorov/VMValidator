<?php


use PHPUnit\Framework\TestCase;
use RMValidator\Attributes\PropertyAttributes\Collection\CollectionAttribute;
use RMValidator\Exceptions\CollectionException;

class CollectionAttributeTest extends TestCase {

    /**
    * @doesNotPerformAssertions
    */
    public function testCollectionAttribute_shouldNotThrow()
    {
        $attr = new CollectionAttribute();
        $attr->validate([]);
    }

    public function testCollectionAttribute_shouldThrow()
    {
        $this->expectException(CollectionException::class);
        $attr = new CollectionAttribute();
        $attr->validate('not an array');
    }
}