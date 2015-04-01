<?php
/*
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


use Fake\CollectionAbstractFake;

class CollectionAbstractTest extends \PHPUnit_Framework_TestCase
{
    /** @var \Fake\CollectionAbstractFake $collection */
    private $collection;

    private $dummyType;

    public function setUp()
    {
        $this->dummyType = $this->prophesize('CollectionType\Type\StringType');
        $this->dummyType->willImplement('CollectionType\Type\TypeInterface');

        $this->collection = new CollectionAbstractFake($this->dummyType->reveal());
    }

    public function tearDown()
    {
        $this->collection = null;
        $this->dummyType = null;
    }

    /**
     * @covers       CollectionType\CollectionAbstract::getAll
     */
    public function testGetAllForNoneValues()
    {
        $result = $this->collection->getAll();

        $this->assertEquals([], $result);
    }

    /**
     * @covers       CollectionType\CollectionAbstract::getAll
     */
    public function testGetAllForFewValues()
    {
        $this->collection->add('A');
        $this->collection->add('B');
        $this->collection->add('C');
        $this->collection->add('D');
        $this->collection->add('E');

        $result = $this->collection->getAll();

        $this->assertEquals(['A', 'B', 'C', 'D', 'E'], $result);
    }

    /**
     * @expectedException \CollectionType\Exception\InvalidTypeException
     *
     * @covers       CollectionType\CollectionAbstract::addAll
     * @covers       CollectionType\CollectionAbstract::getType
     * @covers       CollectionType\ValueTypeTrait::getValueType
     */
    public function testAddAllForWrongTypeCollectionThrowException()
    {
        $dummy = $this->prophesize('CollectionType\Type\IntegerType');
        $dummy->willImplement('CollectionType\Type\TypeInterface');
        $intDummy = $dummy->reveal();
        $intCollection = new CollectionAbstractFake($intDummy);

        $this->collection->addAll($intCollection);
    }

    /**
     * @covers       CollectionType\CollectionAbstract::addAll
     */
    public function testAddAllForEmptyAndEmpty()
    {
        $addedCollection = clone $this->collection;
        $this->collection->addAll($addedCollection);

        $this->assertEquals([], $this->collection->getAll());
    }

    /**
     * @covers       CollectionType\CollectionAbstract::addAll
     */
    public function testAddAllForDifferentValues()
    {
        $addedCollection = clone $this->collection;

        $this->collection->add('A');
        $this->collection->add('B');
        $this->collection->add('C');

        $addedCollection->add('D');
        $addedCollection->add('E');

        $this->collection->addAll($addedCollection);

        $this->assertEquals(['A', 'B', 'C', 'D', 'E'], $this->collection->getAll());
    }

    /**
     * @covers       CollectionType\CollectionAbstract::equalType
     * @covers       CollectionType\CollectionAbstract::getType
     * @covers       CollectionType\ValueTypeTrait::getValueType
     */
    public function testEqualTypeForDifferentTypes()
    {
        $dummy = $this->prophesize('CollectionType\Type\IntegerType');
        $dummy->willImplement('CollectionType\Type\TypeInterface');
        $intDummy = $dummy->reveal();

        $result = $this->collection->equalType($intDummy);

        $this->assertFalse($result);
    }

    /**
     * @covers       CollectionType\CollectionAbstract::equalType
     * @covers       CollectionType\CollectionAbstract::getType
     * @covers       CollectionType\ValueTypeTrait::getValueType
     */
    public function testEqualTypeForTheSameType()
    {
        $result = $this->collection->equalType($this->dummyType->reveal());

        $this->assertTrue($result);
    }

    /**
     * @covers       CollectionType\CollectionAbstract::toArray
     */
    public function testToArrayForSomeValues()
    {
        $this->collection->add('A');
        $this->collection->add('B');
        $this->collection->add('C');

        $result = $this->collection->toArray();
        $this->assertEquals(['A', 'B', 'C'], $result);
    }

    /**
     * @expectedException \CollectionType\Exception\InvalidTypeException
     *
     * @covers       CollectionType\CollectionAbstract::removeAll
     */
    public function testRemoveAllForDifferentValueType()
    {
        $this->collection->add('A');
        $this->collection->add('B');
        $this->collection->add('C');

        $dummyType = $this->prophesize('CollectionType\Type\IntegerType');
        $dummyType->willImplement('CollectionType\Type\TypeInterface');

        $someCollection = new CollectionAbstractFake($dummyType->reveal());

        $someCollection->add(1);
        $someCollection->add(2);

        $this->collection->removeAll($someCollection);
    }

    /**
     * @covers       CollectionType\CollectionAbstract::removeAll
     */
    public function testRemoveAllWhenDoNotContainValue()
    {
        $someCollection = clone $this->collection;
        $someCollection->add('A');
        $someCollection->add('X');

        $this->collection->add('A');
        $this->collection->add('B');
        $this->collection->add('C');

        $result = $this->collection->removeAll($someCollection);

        $this->assertFalse($result);
    }

    /**
     * @covers       CollectionType\CollectionAbstract::removeAll
     */
    public function testRemoveAllWhenContainValue()
    {
        $value = 'A';

        $someCollection = clone $this->collection;
        $someCollection->add($value);

        $this->dummyType->isValid($value)->willReturn(true);

        $this->collection->add('A');
        $this->collection->add('B');
        $this->collection->add('C');

        $result = $this->collection->removeAll($someCollection);

        $this->assertTrue($result);
    }

    /**
     * @covers       CollectionType\CollectionAbstract::removeAll
     */
    public function testRemoveAllWhenContainValueAfterRemove()
    {
        $value = 'A';

        $someCollection = clone $this->collection;
        $someCollection->add($value);

        $this->dummyType->isValid($value)->willReturn(true);

        $this->collection->add('A');
        $this->collection->add('B');
        $this->collection->add('C');

        $this->collection->removeAll($someCollection);

        $result = $this->collection->getAll();

        $this->assertEquals(['B', 'C'], $result);
    }

    /**
     * @expectedException \CollectionType\Exception\InvalidTypeException
     *
     * @covers       CollectionType\CollectionAbstract::containsAll
     * @covers       CollectionType\CollectionAbstract::getType
     * @covers       CollectionType\ValueTypeTrait::getValueType
     */
    public function testContainsAllForDifferentValueType()
    {
        $this->collection->add('A');
        $this->collection->add('B');
        $this->collection->add('C');

        $dummyType = $this->prophesize('CollectionType\Type\IntegerType');
        $dummyType->willImplement('CollectionType\Type\TypeInterface');

        $someCollection = new CollectionAbstractFake($dummyType->reveal());

        $someCollection->add(1);
        $someCollection->add(2);

        $this->collection->containsAll($someCollection);
    }

    /**
     * @covers       CollectionType\CollectionAbstract::containsAll
     */
    public function testContainsAllWhenDoNotContainValue()
    {
        $someCollection = clone $this->collection;
        $someCollection->add('A');
        $someCollection->add('X');

        $this->collection->add('A');
        $this->collection->add('B');
        $this->collection->add('C');

        $result = $this->collection->containsAll($someCollection);

        $this->assertFalse($result);
    }

    /**
     * @covers       CollectionType\CollectionAbstract::containsAll
     */
    public function testContainsAllWhenContainValue()
    {
        $someCollection = clone $this->collection;
        $someCollection->add('A');
        $someCollection->add('C');

        $this->collection->add('A');
        $this->collection->add('B');
        $this->collection->add('C');

        $result = $this->collection->containsAll($someCollection);

        $this->assertTrue($result);
    }

    /**
     * @expectedException \CollectionType\Exception\InvalidTypeException
     *
     * @covers       CollectionType\CollectionAbstract::remove
     * @covers       CollectionType\CollectionAbstract::getType
     * @covers       CollectionType\ValueTypeTrait::getValueType
     */
    public function testRemoveForDifferentValueType()
    {
        $this->collection->add('A');
        $this->collection->add('B');
        $this->collection->add('C');

        $value = 1.9;

        $this->dummyType->isValid($value)->willReturn(false);

        $this->collection->remove($value);
    }

    /**
     * @covers       CollectionType\CollectionAbstract::remove
     * @covers       CollectionType\CollectionAbstract::contains
     */
    public function testRemoveWhenDoNotContainValue()
    {
        $this->collection->add('A');
        $this->collection->add('B');
        $this->collection->add('C');

        $value = 'X';

        $this->dummyType->isValid($value)->willReturn(true);

        $result = $this->collection->remove($value);

        $this->assertFalse($result);
    }

    /**
     * @covers       CollectionType\CollectionAbstract::remove
     * @covers       CollectionType\CollectionAbstract::contains
     */
    public function testRemoveWhenContainValue()
    {
        $this->collection->add('A');
        $this->collection->add('B');
        $this->collection->add('C');

        $value = 'B';

        $this->dummyType->isValid($value)->willReturn(true);

        $result = $this->collection->remove($value);

        $this->assertTrue($result);
    }

    /**
     * @covers       CollectionType\CollectionAbstract::remove
     * @covers       CollectionType\CollectionAbstract::contains
     */
    public function testRemoveForCheckingValuesAfterRemove()
    {
        $this->collection->add('A');
        $this->collection->add('B');
        $this->collection->add('C');

        $value = 'B';

        $this->dummyType->isValid($value)->willReturn(true);

        $this->collection->remove($value);

        $result = $this->collection->getAll();

        $this->assertEquals(['A', 'C'], $result);
    }

    /**
     * @expectedException \CollectionType\Exception\InvalidTypeException
     *
     * @covers       CollectionType\CollectionAbstract::contains
     * @covers       CollectionType\CollectionAbstract::getType
     * @covers       CollectionType\ValueTypeTrait::getValueType
     */
    public function testContainsForDifferentValueType()
    {
        $this->collection->add('A');
        $this->collection->add('B');
        $this->collection->add('C');

        $value = 1.9;

        $this->dummyType->isValid($value)->willReturn(false);

        $this->collection->contains($value);
    }

    /**
     * @covers       CollectionType\CollectionAbstract::contains
     */
    public function testContainsForNotContainValue()
    {
        $this->collection->add('A');
        $this->collection->add('B');
        $this->collection->add('C');

        $value = 'X';

        $this->dummyType->isValid($value)->willReturn(true);

        $result = $this->collection->contains($value);

        $this->assertFalse($result);
    }

    /**
     * @covers       CollectionType\CollectionAbstract::contains
     */
    public function testContainsForContainValue()
    {
        $this->collection->add('A');
        $this->collection->add('B');
        $this->collection->add('C');

        $value = 'B';

        $this->dummyType->isValid($value)->willReturn(true);

        $result = $this->collection->contains($value);

        $this->assertTrue($result);
    }

    /**
     * @covers       CollectionType\CollectionAbstract::clear
     * @covers       CollectionType\CollectionAbstract::getAll
     */
    public function testClear()
    {
        $this->collection->add('A');
        $this->collection->add('B');
        $this->collection->add('C');

        $this->collection->clear();

        $result = $this->collection->getAll();

        $this->assertEquals([], $result);
    }

    /**
     * @expectedException \CollectionType\Exception\InvalidTypeException
     *
     * @covers       CollectionType\CollectionAbstract::equals
     * @covers       CollectionType\CollectionAbstract::getType
     * @covers       CollectionType\ValueTypeTrait::getValueType
     */
    public function testEqualsForDifferentCollectionsTypes()
    {
        $this->collection->add('A');
        $this->collection->add('B');
        $this->collection->add('C');

        $dummyType = $this->prophesize('CollectionType\Type\IntegerType');
        $dummyType->willImplement('CollectionType\Type\TypeInterface');

        $someCollection = new CollectionAbstractFake($dummyType->reveal());

        $someCollection->add(1);
        $someCollection->add(2);

        $this->collection->equals($someCollection);
    }

    /**
     * @covers       CollectionType\CollectionAbstract::equals
     */
    public function testEqualsForDifferentCollectionsValues()
    {
        $someCollection = clone $this->collection;

        $this->collection->add('A');
        $this->collection->add('B');
        $this->collection->add('C');

        $someCollection->add('X');
        $someCollection->add('Y');
        $someCollection->add('Z');

        $result = $this->collection->equals($someCollection);

        $this->assertFalse($result);
    }

    /**
     * @covers       CollectionType\CollectionAbstract::equals
     */
    public function testEqualsForTheSameCollections()
    {
        $someCollection = clone $this->collection;

        $this->collection->add('A');
        $this->collection->add('B');
        $this->collection->add('C');

        $someCollection->add('A');
        $someCollection->add('B');
        $someCollection->add('C');

        $result = $this->collection->equals($someCollection);

        $this->assertTrue($result);
    }
}