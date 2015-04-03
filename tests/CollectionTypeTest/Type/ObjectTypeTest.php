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
