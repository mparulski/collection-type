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

namespace CollectionTypeTest\Collection\CollectionList\LinkedList;

use CollectionType\Collection\CollectionList\LinkedList;

class SetAllTest extends \PHPUnit_Framework_TestCase
{
    private $list;

    private $dummyType;

    public function setUp()
    {
        $this->dummyType = $this->prophesize('CollectionType\TypeValidator\StringTypeValidator');
        $this->dummyType->willImplement('CollectionType\TypeValidator\TypeValidatorInterface');

        $this->list = new LinkedList($this->dummyType->reveal());
    }

    public function tearDown()
    {
        $this->list = null;
        $this->dummyType = null;
    }

    /**
     * @expectedException \CollectionType\Exception\InvalidTypeException
     *
     * @covers       CollectionType\Collection\CollectionList\LinkedList::setAll
     * @covers       CollectionType\Collection\CollectionList\LinkedList::__construct
     */
    public function testSetAllForIncorrectType()
    {
        $dummyType = $this->prophesize('CollectionType\TypeValidator\IntegerTypeValidator');
        $dummyType->willImplement('CollectionType\TypeValidator\TypeValidatorInterface');

        $otherList = new LinkedList($dummyType->reveal());

        $this->list->setAll(0, $otherList);
    }

    /**
     * @expectedException \CollectionType\Exception\IndexException
     *
     * @covers       CollectionType\Collection\CollectionList\LinkedList::setAll
     * @covers       CollectionType\Collection\CollectionList\LinkedList::__construct
     * @covers       CollectionType\Common\Sequential\SequentialTrait::validateIndex
     */
    public function testSetAllForIncorrectIndex()
    {
        $value = '1';
        $this->dummyType->isValid($value)->willReturn(true);

        $otherList = new LinkedList($this->dummyType->reveal());
        $otherList->add($value);

        $this->list->setAll(-1, $otherList);
    }

    /**
     * @covers       CollectionType\Collection\CollectionList\LinkedList::setAll
     * @covers       CollectionType\Collection\CollectionList\LinkedList::__construct
     * @covers       CollectionType\Common\Sequential\SequentialTrait::validateIndex
     */
    public function testSetAll()
    {
        $value1 = '1';
        $this->dummyType->isValid($value1)->willReturn(true);
        $value2 = '2';
        $this->dummyType->isValid($value2)->willReturn(true);
        $value3 = '3';
        $this->dummyType->isValid($value3)->willReturn(true);
        $valueA = 'A';
        $this->dummyType->isValid($valueA)->willReturn(true);
        $valueB = 'B';
        $this->dummyType->isValid($valueB)->willReturn(true);

        $this->list->add($value1);
        $this->list->add($value2);
        $this->list->add($value3);

        $otherList = new LinkedList($this->dummyType->reveal());
        $otherList->add($valueA);
        $otherList->add($valueB);

        $this->list->setAll(2, $otherList);

        $result = $this->list->getAll();

        $this->assertEquals([$value1, $value2, $valueA, $valueB, $value3], $result);
    }
}
