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

namespace CollectionTypeTest\Common;

use Fake\Common\ValueTypeTraitFake;

class ValueTypeTraitTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers       CollectionType\Common\ValueTypeTrait::equalValueType
     * @covers       CollectionType\Common\ValueTypeTrait::setValueType
     */
    public function testEqualValueTypeForTheSameType()
    {
        $dummyIntegerValidatorType = $this->prophesize('CollectionType\TypeValidator\IntegerTypeValidator');
        $dummyIntegerValidatorType->willImplement('CollectionType\TypeValidator\TypeValidatorInterface');

        $valueTypeTrait = new ValueTypeTraitFake($dummyIntegerValidatorType->reveal());

        $result = $valueTypeTrait->equalValueType($dummyIntegerValidatorType->reveal());

        $this->assertTrue($result);
    }

    /**
     * @covers       CollectionType\Common\ValueTypeTrait::equalValueType
     * @covers       CollectionType\Common\ValueTypeTrait::setValueType
     */
    public function testEqualValueTypeForDifferentType()
    {
        $dummyIntegerValidatorType = $this->prophesize('CollectionType\TypeValidator\IntegerTypeValidator');
        $dummyIntegerValidatorType->willImplement('CollectionType\TypeValidator\TypeValidatorInterface');

        $valueTypeTrait = new ValueTypeTraitFake($dummyIntegerValidatorType->reveal());

        $dummyStringValidatorType = $this->prophesize('CollectionType\TypeValidator\StringTypeValidator');
        $dummyStringValidatorType->willImplement('CollectionType\TypeValidator\TypeValidatorInterface');

        $result = $valueTypeTrait->equalValueType($dummyStringValidatorType->reveal());

        $this->assertFalse($result);
    }
}