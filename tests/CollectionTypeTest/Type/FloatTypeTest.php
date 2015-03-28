<?php
namespace CollectionTypeTest;

use CollectionType\Type\FloatType;

class FloatTypeTest extends \PHPUnit_Framework_TestCase
{

    private $floatType;

    public function setUp()
    {
        $this->floatType = new FloatType();
    }

    public function tearDown()
    {
        $this->floatType = null;
    }

    /**
     * @covers       CollectionType\Type\FloatType::isValid
     * @dataProvider correctValuesDataProvider
     */
    public function testIsCorrectTypeSetCorrectValue($value)
    {
        $result = $this->floatType->isValid($value);

        $this->assertTrue($result);
    }

    /**
     * @covers       CollectionType\Type\FloatType::isValid
     * @dataProvider incorrectValuesDataProvider
     */
    public function testIsCorrectTypeSetIncorrectValue($value)
    {
        $value = $this->floatType->isValid($value);

        $this->assertFalse($value);
    }

    public function correctValuesDataProvider()
    {
        return [
            [
                PHP_INT_MAX + 1 //value: 2147483648 (on a 32-bit system)
            ],
            [
                -\PHP_INT_MAX - 2 //value: -2147483649 (on a 32-bit system)
            ],
            [
                0.0
            ],
            [
                1.2e3
            ]
        ];
    }

    public function incorrectValuesDataProvider()
    {
        return [
            [
                1
            ],
            [
                0
            ],
            [
                PHP_INT_MAX //value: 2147483647 (on a 32-bit system)
            ],
            [
                'string'
            ],
            [
                [
                    1,
                    2,
                    3
                ]
            ],
            [
                null
            ],
            [
                new \stdClass()
            ]
        ];
    }
}
