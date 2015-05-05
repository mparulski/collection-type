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

use CollectionType\Collection\CollectionSet\HashSet;
use CollectionType\Collection\CollectionSet\LinkedSet;

class SetAllTest extends \PHPUnit_Framework_TestCase
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
     * @expectedException \CollectionType\Exception\InvalidTypeException
     *
     * @covers       CollectionType\Collection\CollectionSet\LinkedSet::setAll
     * @covers       CollectionType\Collection\CollectionSet\LinkedSet::__construct
     * @covers       CollectionType\Common\ValueTypeTrait::validateValueType
     */
    public function testSetForIncorrectSetType()
    {
        $dummyType = $this->prophesize('CollectionType\TypeValidator\IntegerTypeValidator');
        $dummyType->willImplement('CollectionType\TypeValidator\TypeValidatorInterface');
        $otherSet = new HashSet($dummyType->reveal());

        $this->set->setAll(1, $otherSet);

    }

    /**
     * @covers       CollectionType\Collection\CollectionSet\LinkedSet::setAll
     * @covers       CollectionType\Collection\CollectionSet\LinkedSet::__construct
     * @covers       CollectionType\Common\Sequential\SequentialTrait::setCollectionIntoIndex
     * @covers       CollectionType\Common\ValueTypeTrait::validateValueType
     * @covers       CollectionType\Common\ValueTypeTrait::equalValueType
     */
    public function testSetForFilledSetForValues()
    {
        $value0 = '0';
        $this->dummyType->isValid($value0)->willReturn(true);
        $this->set->add($value0);

        $value1 = 'old value index: 1';
        $this->dummyType->isValid($value1)->willReturn(true);
        $this->set->add($value1);

        $value2 = 'old value index: 2';
        $this->dummyType->isValid($value2)->willReturn(true);
        $this->set->add($value2);

        $value3 = 'old value index: 3';
        $this->dummyType->isValid($value3)->willReturn(true);
        $this->set->add($value3);

        $otherSet = new HashSet($this->dummyType->reveal());

        $valueN1 = 'new value index: 1';
        $this->dummyType->isValid($valueN1)->willReturn(true);
        $otherSet->add($valueN1);

        $valueN2 = 'new value index: 2';
        $this->dummyType->isValid($valueN2)->willReturn(true);
        $otherSet->add($valueN2);

        $this->set->setAll(1, $otherSet);

        $result = $this->set->getAll();

        $this->assertEquals([$value0, $valueN1, $valueN2, $value1, $value2, $value3], $result);
    }

    /**
     * @covers       CollectionType\Collection\CollectionSet\LinkedSet::setAll
     * @covers       CollectionType\Collection\CollectionSet\LinkedSet::__construct
     * @covers       CollectionType\Common\Sequential\SequentialTrait::setCollectionIntoIndex
     * @covers       CollectionType\Common\ValueTypeTrait::validateValueType
     * @covers       CollectionType\Common\ValueTypeTrait::equalValueType
     */
    public function testSetForFilledSetForRepeatValues()
    {
        $value0 = '0';
        $this->dummyType->isValid($value0)->willReturn(true);
        $this->set->add($value0);

        $value1 = 'old value index: 1 -> 2';
        $this->dummyType->isValid($value1)->willReturn(true);
        $this->set->add($value1);

        $value2 = 'old value index: 2 -> 3';
        $this->dummyType->isValid($value2)->willReturn(true);
        $this->set->add($value2);

        $value3 = 'old value index: 3 -> 4';
        $this->dummyType->isValid($value3)->willReturn(true);
        $this->set->add($value3);

        $otherSet = new HashSet($this->dummyType->reveal());

        $valueN1 = 'new value index: 1 -> 1';
        $this->dummyType->isValid($valueN1)->willReturn(true);
        $otherSet->add($valueN1);

        $otherSet->add($value2);

        $this->set->setAll(1, $otherSet);

        $result = $this->set->getAll();

        $this->assertEquals([$value0, $valueN1, $value1, $value2, $value3], $result);
    }
}
