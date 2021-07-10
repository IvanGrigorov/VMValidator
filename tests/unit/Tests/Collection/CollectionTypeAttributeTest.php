<?php


use PHPUnit\Framework\TestCase;
use RMValidator\Attributes\PropertyAttributes\Collection\CollectionTypeAttribute;
use RMValidator\Exceptions\CollectionException;
use RMValidator\Exceptions\CollectionTypeException;
use RMValidator\Exceptions\EmptyCollectionException;
use RMValidator\Options\OptionsModel;

class CollectionTypeAttributeTest extends TestCase {

    /**
    * @doesNotPerformAssertions
    */
    public function testCollectionTypeAttribute_shouldNotThrow()
    {
        $attr = new CollectionTypeAttribute(collectionType: OptionsModel::class);
        $attr->validate([new OptionsModel(), new OptionsModel()]);
    }

    public function testCollectionTypeAttribute_shouldNotThrowOnEmptyCollection()
    {
        $attr = new CollectionTypeAttribute(collectionType: OptionsModel::class);
        $attr->validate([]);
    }

    public function testCollectionTypeAttribute_shouldThrowOnNoCollection()
    {
        $this->expectException(CollectionException::class);
        $attr = new CollectionTypeAttribute(collectionType: OptionsModel::class);
        $attr->validate('a');
    }

    public function testCollectionTypeAttribute_shouldThrowOnEmptyCollection()
    {
        $this->expectException(EmptyCollectionException::class);
        $attr = new CollectionTypeAttribute(collectionType: OptionsModel::class, isEmptyValid: false);
        $attr->validate([]);
    }

    public function testCollectionTypeAttribute_shouldThrow()
    {
        $this->expectException(CollectionTypeException::class);
        $attr = new CollectionTypeAttribute(collectionType: OptionsModel::class);
        $attr->validate(['a']);
    }
}