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

namespace CollectionTypeTest\TypeValidator;

use CollectionType\TypeValidator\BoolTypeValidator;

class BoolTypeTest extends \PHPUnit_Framework_TestCase
{

    private $boolType;

    public function setUp()
    {
        $this->boolType = new BoolTypeValidator();
    }

    public function tearDown()
    {
        $this->boolType = null;
    }

    /**
     * @covers CollectionType\TypeValidator\BoolTypeValidator::isValid
     * @dataProvider correctValuesDataProvider
     */
    public function testIsCorrectTypeSetCorrectValue($value)
    {
        $result = $this->boolType->isValid($value);

        $this->assertTrue($result);
    }

    /**
     * @covers       CollectionType\TypeValidator\BoolTypeValidator::isValid
     * @dataProvider incorrectValuesDataProvider
     */
    public function testIsCorrectTypeSetIncorrectValue($value)
    {
        $result = $this->boolType->isValid($value);

        $this->assertFalse($result);
    }

    public function correctValuesDataProvider()
    {
        return [
            [
                true
            ],
            [
                false
            ]
        ];
    }

    public function incorrectValuesDataProvider()
    {
        return [
            [
                null
            ],
            [
                ''
            ],
            [
                'true'
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
