<?php
use CollectionType\Type\IntegerType;

class IntegerTypeTest extends \PHPUnit_Framework_TestCase
{

    private $integerType;

    public function setUp()
    {
        $this->integerType = new IntegerType();
    }

    public function tearDown()
    {
        $this->integerType = null;
    }

    /**
     * @covers       CollectionType\Type\IntegerType::isValid
     * @dataProvider correctValuesDataProvider
     */
    public function testIsCorrectTypeSetCorrectValue($value)
    {
        $retult = $this->integerType->isValid($value);

        $this->assertTrue($retult);
    }

    /**
     * @covers       CollectionType\Type\IntegerType::isValid
     * @dataProvider incorrectValuesDataProvider
     */
    public function testIsCorrectTypeSetIncorrectValue($value)
    {
        $result = $this->integerType->isValid($value);

        $this->assertFalse($result);
    }

    public function correctValuesDataProvider()
    {
        return [
            [
                PHP_INT_MAX //value: 2147483647 (on a 32-bit system)
            ],
            [
                0
            ],
            [
                1
            ],
            [
                -\PHP_INT_MAX - 1 //value: -2147483648 (on a 32-bit system)
            ]
        ];
    }

    public function incorrectValuesDataProvider()
    {
        return [
            [
                PHP_INT_MAX + 1 //value: 2147483648 (on a 32-bit system)
            ],
            [
                0.1
            ],
            [
                -\PHP_INT_MAX - 2 //value: -2147483649 (on a 32-bit system)
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
