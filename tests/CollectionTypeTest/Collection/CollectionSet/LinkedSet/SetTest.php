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

namespace CollectionTypeTest\Collection\CollectionSet\LinkedSet;

use CollectionType\Collection\CollectionSet\LinkedSet;

class SetTest extends \PHPUnit_Framework_TestCase
{
    /** @var \CollectionType\Collection\CollectionSet\LinkedSet $set */
    private $set;

    private $dummyType;

    public function setUp()
    {
        $this->dummyType = $this->prophesize('CollectionType\TypeValidator\StringTypeValidator');
        $this->dummyType->willImplement('CollectionType\TypeValidator\TypeValidatorInterface');

        $this->set = new LinkedSet($this->dummyType->reveal());
    }

    public function tearDown()
    {
        $this->set = null;
        $this->dummyType = null;
    }

    /**
     * @covers       CollectionType\Collection\CollectionSet\LinkedSet::set
     * @covers       CollectionType\Collection\CollectionSet\LinkedSet::__construct
     * @covers       CollectionType\Collection\CollectionAbstract::contains
     * @covers       CollectionType\Common\ValueTypeTrait::validateValueForValueType
     */
    public function testSetForContainsValue()
    {
        $value0 = '0';
        $this->dummyType->isValid($value0)->willReturn(true);
        $this->set->add($value0);

        $result = $this->set->set(1, $value0);

        $this->assertFalse($result);
    }

    /**
     * @expectedException \CollectionType\Exception\IndexException
     *
     * @covers       CollectionType\Collection\CollectionSet\LinkedSet::set
     * @covers       CollectionType\Collection\CollectionSet\LinkedSet::__construct
     * @covers       CollectionType\Collection\CollectionAbstract::contains
     * @covers       CollectionType\Common\Sequential\SequentialTrait::setValueIntoIndex
     * @covers       CollectionType\Common\Sequential\SequentialTrait::validateIndex
     */
    public function testSetForIncorrectIndexValue()
    {
        $index = 7.2;
        $value = '1';
        $this->dummyType->isValid($value)->willReturn(true);

        $this->set->set($index, $value);
    }

    /**
     * @covers       CollectionType\Collection\CollectionSet\LinkedSet::set
     * @covers       CollectionType\Collection\CollectionSet\LinkedSet::__construct
     * @covers       CollectionType\Collection\CollectionAbstract::contains
     * @covers       CollectionType\Common\Sequential\SequentialTrait::setValueIntoIndex
     * @covers       CollectionType\Common\Sequential\SequentialTrait::validateIndex
     * @covers       CollectionType\Common\ValueTypeTrait::validateValueForValueType
     */
    public function testSetForFilledSetForValues()
    {
        $value0 = '0';
        $this->dummyType->isValid($value0)->willReturn(true);
        $this->set->add($value0);

        $value1 = 'old value index: 1';
        $this->dummyType->isValid($value1)->willReturn(true);
        $this->set->add($value1);

        $value2 = '2';
        $this->dummyType->isValid($value2)->willReturn(true);
        $this->set->add($value2);

        $value3 = '3';
        $this->dummyType->isValid($value3)->willReturn(true);
        $this->set->add($value3);

        $index = 1;
        $value = 'new value index: 1';
        $this->dummyType->isValid($value)->willReturn(true);

        $this->set->set($index, $value);

        $result = $this->set->getAll();

        $this->assertEquals([$value0, $value, $value1, $value2, $value3], $result);
    }

    /**
     * @covers       CollectionType\Collection\CollectionSet\LinkedSet::set
     * @covers       CollectionType\Collection\CollectionSet\LinkedSet::__construct
     * @covers       CollectionType\Collection\CollectionAbstract::contains
     * @covers       CollectionType\Common\Sequential\SequentialTrait::setValueIntoIndex
     * @covers       CollectionType\Common\Sequential\SequentialTrait::validateIndex
     * @covers       CollectionType\Common\ValueTypeTrait::validateValueForValueType
     */
    public function testSetForBigIndexValue()
    {
        $value0 = '0';
        $this->dummyType->isValid($value0)->willReturn(true);
        $this->set->add($value0);

        $value1 = '1';
        $this->dummyType->isValid($value1)->willReturn(true);
        $this->set->add($value1);

        $value2 = '2';
        $this->dummyType->isValid($value2)->willReturn(true);
        $this->set->add($value2);

        $value3 = '3';
        $this->dummyType->isValid($value3)->willReturn(true);
        $this->set->add($value3);

        $index = 100;
        $value = 'last';
        $this->dummyType->isValid($value)->willReturn(true);

        $this->set->set($index, $value);

        $result = $this->set->getAll();

        $this->assertEquals([$value0, $value1, $value2, $value3, $value], $result);
    }
}