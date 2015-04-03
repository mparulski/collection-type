<?php
/**
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * This software consists of voluntary contributions made by many individuals
 * and is licensed under the MIT license.
 */

namespace CollectionTypeTest;

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
        $result = $this->arrayType->isValid($value);

        $this->assertTrue($result);
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
