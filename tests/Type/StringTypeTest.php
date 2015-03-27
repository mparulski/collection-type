<?php
use CollectionType\Type\StringType;

class StringTypeTest extends \PHPUnit_Framework_TestCase
{

    private $stringType;

    public function setUp()
    {
        $this->stringType = new StringType();
    }

    public function tearDown()
    {
        $this->stringType = null;
    }

    /**
     * @covers       CollectionType\Type\StringType::isValid
     * @dataProvider correctValuesDataProvider
     */
    public function testIsCorrectTypeSetCorrectValue($value)
    {
        $result = $this->stringType->isValid($value);

        $this->assertTrue($result);
    }

    /**
     * @covers       CollectionType\Type\StringType::isValid
     * @dataProvider incorrectValuesDataProvider
     */
    public function testIsCorrectTypeSetIncorrectValue($value)
    {
        $result = $this->stringType->isValid($value);

        $this->assertFalse($result);
    }

    public function correctValuesDataProvider()
    {
        return [
            [
                ''
            ],
            [
                '1'
            ],
            [
                'array()'
            ],
            [
                'string'
            ]
        ];
    }

    public function incorrectValuesDataProvider()
    {
        return [
            [
                array()
            ],
            [
                array(
                    1,
                    2,
                    3
                )
            ],
            [
                1.1
            ],
            [
                1.2e3
            ],
            [
                1
            ],
            [
                PHP_INT_MAX
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
