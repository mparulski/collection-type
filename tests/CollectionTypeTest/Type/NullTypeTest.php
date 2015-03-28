<?php
namespace CollectionTypeTest;

use CollectionType\Type\NullType;

class NullTypeTest extends \PHPUnit_Framework_TestCase
{

    private $nullType;

    public function setUp()
    {
        $this->nullType = new NullType();
    }

    public function tearDown()
    {
        $this->nullType = null;
    }

    /**
     * @covers CollectionType\Type\NullType::isValid
     */
    public function testIsCorrectTypeSetCorrectValue()
    {
        $result = $this->nullType->isValid(null);

        $this->assertTrue($result);
    }

    /**
     * @covers       CollectionType\Type\NullType::isValid
     * @dataProvider incorrectValuesDataProvider
     */
    public function testIsCorrectTypeSetIncorrectValue($value)
    {
        $result = $this->nullType->isValid($value);

        $this->assertFalse($result);
    }

    public function incorrectValuesDataProvider()
    {
        return [
            [
                ''
            ],
            [
                'string'
            ],
            [
                array()
            ],
            [
                0
            ],
            [
                1.09
            ],
            [
                new \stdClass()
            ]
        ];
    }
}
