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

use Fake\Collection\CollectionSet\SetAbstractFake;

class SetAbstractTest extends \PHPUnit_Framework_TestCase
{
    /** @var \Fake\Collection\CollectionSet\SetAbstractFake $set */
    private $set;

    private $dummyType;

    public function setUp()
    {
        $this->dummyType = $this->prophesize('CollectionType\TypeValidator\StringTypeValidator');
        $this->dummyType->willImplement('CollectionType\TypeValidator\TypeValidatorInterface');

        $this->set = new SetAbstractFake($this->dummyType->reveal());
    }

    public function tearDown()
    {
        $this->set = null;
        $this->dummyType = null;
    }

    /**
     * @expectedException \CollectionType\Exception\InvalidTypeException
     *
     * @covers       CollectionType\Collection\CollectionSet\SetAbstract::add
     * @covers       CollectionType\Collection\CollectionSet\SetAbstract::contains
     * @covers       CollectionType\Collection\CollectionSet\SetAbstract::__construct
     * @covers       CollectionType\Common\ValueTypeTrait::validateValueForValueType
     */
    public function testAddForWrongTypeCollectionThrowException()
    {
        $value = 1;
        $this->dummyType->isValid($value)->willReturn(false);
        $this->set->add($value);
    }

    /**
     * @covers       CollectionType\Collection\CollectionSet\SetAbstract::add
     * @covers       CollectionType\Collection\CollectionSet\SetAbstract::contains
     * @covers       CollectionType\Collection\CollectionSet\SetAbstract::__construct
     * @covers       CollectionType\Common\ValueTypeTrait::validateValueForValueType
     */
    public function testAddForUnrepeatableValues()
    {
        $value = 'A';
        $this->dummyType->isValid($value)->willReturn(true);
        $resultA = $this->set->add($value);

        $value = 'B';
        $this->dummyType->isValid($value)->willReturn(true);
        $resultB = $this->set->add($value);

        $value = 'C';
        $this->dummyType->isValid($value)->willReturn(true);
        $resultC = $this->set->add($value);

        $this->assertTrue($resultA && $resultB && $resultC);
    }

    /**
     * @covers       CollectionType\Collection\CollectionSet\SetAbstract::add
     * @covers       CollectionType\Collection\CollectionSet\SetAbstract::contains
     * @covers       CollectionType\Collection\CollectionSet\SetAbstract::__construct
     * @covers       CollectionType\Common\ValueTypeTrait::validateValueForValueType
     */
    public function testAddForRepeatableValues()
    {
        $value = 'A';
        $this->dummyType->isValid($value)->willReturn(true);
        $this->set->add($value);

        $value = 'A';
        $this->dummyType->isValid($value)->willReturn(true);
        $result = $this->set->add($value);

        $this->assertFalse($result);
    }

    /**
     * @expectedException \CollectionType\Exception\InvalidTypeException
     *
     * @covers       CollectionType\Collection\CollectionSet\SetAbstract::addAll
     */
    public function testAddAllForWrongTypeCollectionThrowException()
    {
        $dummy = $this->prophesize('CollectionType\TypeValidator\IntegerTypeValidator');
        $dummy->willImplement('CollectionType\TypeValidator\TypeValidatorInterface');
        $intDummy = $dummy->reveal();
        $intCollection = new SetAbstractFake($intDummy);

        $this->set->addAll($intCollection);
    }

    /**
     * @covers       CollectionType\Collection\CollectionSet\SetAbstract::addAll
     * @covers       CollectionType\Common\Util\UtilTrait::diffArrays
     */
    public function testAddAllForEmptyAndEmpty()
    {
        $addedCollection = clone $this->set;
        $this->set->addAll($addedCollection);

        $this->assertEquals([], $this->set->getAll());
    }

    /**
     * @covers       CollectionType\Collection\CollectionSet\SetAbstract::addAll
     * @covers       CollectionType\Common\Util\UtilTrait::diffArrays
     */
    public function testAddAllForDifferentValues()
    {
        $valueA = 'A';
        $valueB = 'B';
        $valueC = 'C';
        $valueD = 'D';
        $valueE = 'E';

        $addedCollection = clone $this->set;

        $this->dummyType->isValid($valueA)->willReturn(true);
        $this->set->add($valueA);
        $this->dummyType->isValid($valueB)->willReturn(true);
        $this->set->add($valueB);
        $this->dummyType->isValid($valueC)->willReturn(true);
        $this->set->add($valueC);

        $this->dummyType->isValid($valueA)->willReturn(true);
        $this->set->add($valueA);
        $this->dummyType->isValid($valueD)->willReturn(true);
        $this->set->add($valueD);
        $this->dummyType->isValid($valueE)->willReturn(true);
        $this->set->add($valueE);

        $this->set->addAll($addedCollection);

        $this->assertEquals(['A', 'B', 'C', 'D', 'E'], $this->set->getAll());
    }
}