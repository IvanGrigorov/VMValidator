<?php


use PHPUnit\Framework\TestCase;
use RMValidator\Attributes\PropertyAttributes\Object\HasPropertyAttribute;
use RMValidator\Exceptions\HasPropertyException;

class HasPropertyAttributeTest extends TestCase {

     /**
    * @doesNotPerformAssertions
    */
    public function testHasPropertyAttribute_shouldNotThrow()
    {
        $attr = new HasPropertyAttribute(propertyNameExists: 'prop');
        $obj = new stdClass();
        $obj->prop = true;
        $attr->validate($obj);
    }

    public function testHasPropertyAttribute_shouldThrow()
    {
        $this->expectException(HasPropertyException::class);
        $attr = new HasPropertyAttribute(propertyNameExists: 'prop');
        $obj = new stdClass();
        $attr->validate($obj);
    }
}