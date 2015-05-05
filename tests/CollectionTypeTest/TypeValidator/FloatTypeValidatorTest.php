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

use CollectionType\TypeValidator\FloatTypeValidator;

class FloatTypeTest extends \PHPUnit_Framework_TestCase
{

    private $floatType;

    public function setUp()
    {
        $this->floatType = new FloatTypeValidator();
    }

    public function tearDown()
    {
        $this->floatType = null;
    }

    /**
     * @covers       CollectionType\TypeValidator\FloatTypeValidator::isValid
     * @dataProvider correctValuesDataProvider
     */
    public function testIsCorrectTypeSetCorrectValue($value)
    {
        $result = $this->floatType->isValid($value);

        $this->assertTrue($result);
    }

    /**
     * @covers       CollectionType\TypeValidator\FloatTypeValidator::isValid
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
