<?php
use CollectionType\Type\ObjectType;

class ObjectTypeTest extends \PHPUnit_Framework_TestCase
{

    private $objectType;

    public function setUp()
    {
        $this->objectType = new ObjectType();
    }

    public function tearDown()
    {
        $this->objectType = null;
    }

    /**
     * @covers CollectionType\Type\ObjectType::isValid
     */
    public function testIsCorrectTypeSetCorrectValue()
    {
        $obj = new \stdClass();
        $result = $this->objectType->isValid($obj);

        $this->assertTrue($result);
    }

    /**
     * @covers       CollectionType\Type\ObjectType::isValid
     * @dataProvider incorrectValuesDataProvider
     */
    public function testIsCorrectTypeSetIncorrectValue($value)
    {
        $result = $this->objectType->isValid($value);

        $this->assertFalse($result);
    }

    public function incorrectValuesDataProvider()
    {
        return [
            [
                array()
            ],
            [
                1.01
            ],
            [
                127
            ],
            [
                null
            ],
            [
                'string'
            ],
            [
                ''
            ]
        ];
    }
}
