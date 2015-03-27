<?php
use CollectionType\Type\ArrayType;

class ArrayTypeTest extends \PHPUnit_Framework_TestCase
{

    private $arrayType;

    public function setUp()
    {
        $this->arrayType = new ArrayType();
    }

    public function tearDown()
    {
        $this->arrayType = null;
    }

    /**
     * @covers       CollectionType\Type\ArrayType::isValid
     * @dataProvider correctValuesDataProvider
     */
    public function testIsCorrectTypeSetCorrectValue($value)
    {
        $retult = $this->arrayType->isValid($value);

        $this->assertTrue($retult);
    }

    /**
     * @covers       CollectionType\Type\ArrayType::isValid
     * @dataProvider incorrectValuesDataProvider
     */
    public function testIsCorrectTypeSetIncorrectValue($value)
    {
        $result = $this->arrayType->isValid($value);

        $this->assertFalse($result);
    }

    public function correctValuesDataProvider()
    {
        return [
            [
                array()
            ],
            [
                [
                    1,
                    2,
                    3
                ]
            ],
            [
                [
                    '1',
                    'two',
                    '3.0'
                ]
            ],
            [
                [
                    null,
                    new \stdClass()
                ]
            ]
        ];
    }

    public function incorrectValuesDataProvider()
    {
        return [
            [
                PHP_INT_MAX + 1
            ],
            [
                0.1
            ],
            [
                -\PHP_INT_MAX - 1
            ],
            [
                'string'
            ],
            [
                1
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
