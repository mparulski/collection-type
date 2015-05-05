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

use CollectionType\TypeValidator\NullTypeValidator;

class NullTypeTest extends \PHPUnit_Framework_TestCase
{

    private $nullType;

    public function setUp()
    {
        $this->nullType = new NullTypeValidator();
    }

    public function tearDown()
    {
        $this->nullType = null;
    }

    /**
     * @covers CollectionType\TypeValidator\NullTypeValidator::isValid
     */
    public function testIsCorrectTypeSetCorrectValue()
    {
        $result = $this->nullType->isValid(null);

        $this->assertTrue($result);
    }

    /**
     * @covers       CollectionType\TypeValidator\NullTypeValidator::isValid
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
