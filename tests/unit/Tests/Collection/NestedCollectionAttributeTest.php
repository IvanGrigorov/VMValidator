<?php


use PHPUnit\Framework\TestCase;
use RMValidator\Attributes\PropertyAttributes\Collection\CollectionTypeAttribute;
use RMValidator\Attributes\PropertyAttributes\Collection\NestedCollectionAttribute;
use RMValidator\Attributes\PropertyAttributes\Numbers\RangeAttribute;
use RMValidator\Exceptions\CollectionException;
use RMValidator\Exceptions\CollectionTypeException;
use RMValidator\Exceptions\EmptyCollectionException;
use RMValidator\Exceptions\ObjectException;

class NestedCollectionAttributeTest extends TestCase {

    /**
    * @doesNotPerformAssertions
    */
    public function testNestedCollectionAttribute_shouldNotThrow()
    {
        $attr = new NestedCollectionAttribute(collectionType:  ValidNestedCollectionAttributeTest::class);
        $attr->validate([new ValidNestedCollectionAttributeTest()]);
    }

    public function testNestedCollectionAttribute_shouldNotThrowOnEmptyCollection()
    {
        $attr = new NestedCollectionAttribute(collectionType: ValidTest::class);
        $attr->validate([]);
    }

    public function testNestedCollectionAttribute_shouldThrowOnNoCollection()
    {
        $this->expectException(CollectionException::class);
        $attr = new NestedCollectionAttribute(collectionType: ValidTest::class);
        $attr->validate('a');
    }

    public function testNestedCollectionAttribute_shouldThrowOnEmptyCollection()
    {
        $this->expectException(EmptyCollectionException::class);
        $attr = new NestedCollectionAttribute(collectionType: ValidTest::class, isEmptyValid: false);
        $attr->validate([]);
    }

    public function testNestedCollectionAttribute_shouldThrow()
    {
        $this->expectException(Exception::class);
        $attr = new NestedCollectionAttribute(collectionType: InvalidNestedCollectionAttributeTest::class);
        $attr->validate([new InvalidNestedCollectionAttributeTest()]);
    }

    public function testNestedCollectionAttribute_shouldThrowOnArrayWithoutObject()
    {
        $this->expectException(CollectionTypeException::class);
        $attr = new NestedCollectionAttribute(collectionType: InvalidNestedCollectionAttributeTest::class);
        $attr->validate(['a']);
    }

}

class InvalidNestedCollectionAttributeTest {

    #[RangeAttribute(from: 1, to: 4)]
    public int $wrongNumber = 5;
}

class ValidNestedCollectionAttributeTest {

    #[RangeAttribute(from: 1, to: 4)]
    public int $wrongNumber = 3;
}