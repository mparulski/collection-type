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

use CollectionType\Collection\CollectionSet\HashSet;
use CollectionType\Collection\CollectionSet\TreeSet;

class AddAllTest extends \PHPUnit_Framework_TestCase
{
    private $set;

    private $dummyType;

    public function setUp()
    {
        $this->dummyType = $this->prophesize('CollectionType\TypeValidator\ObjectTypeValidator');
        $this->dummyType->willImplement('CollectionType\TypeValidator\TypeValidatorInterface');

        $this->set = new TreeSet($this->dummyType->reveal());
    }

    public function tearDown()
    {
        $this->set = null;
        $this->dummyType = null;
    }

    /**
     * @covers  CollectionType\Collection\CollectionSet\TreeSet::addAll
     * @covers  CollectionType\Collection\CollectionSet\TreeSet::sort
     * @covers  CollectionType\Collection\CollectionSet\TreeSet::__construct
     * @covers  CollectionType\Collection\CollectionSet\SetAbstract::addAll
     * @covers  CollectionType\Collection\CollectionSet\SetAbstract::contains
     * @covers  CollectionType\Collection\CollectionSet\SetAbstract::validateValueForValueType
     */
    public function testAddAllForEmptyBaseSet()
    {
        $otherSet = new HashSet($this->dummyType->reveal());

        $value3 = '3';
        $this->dummyType->isValid($value3)->willReturn(true);

        $otherSet->add($value3);

        $value2 = '2';
        $this->dummyType->isValid($value2)->willReturn(true);

        $otherSet->add($value2);

        $value4 = '4';
        $this->dummyType->isValid($value4)->willReturn(true);

        $otherSet->add($value4);

        $value1 = '1';
        $this->dummyType->isValid($value1)->willReturn(true);

        $otherSet->add($value1);

        $this->set->addAll($otherSet);

        $result = $this->set->getAll();

        $this->assertEquals([$value1, $value2, $value3, $value4], $result);
    }

    /**
     * @covers  CollectionType\Collection\CollectionSet\TreeSet::addAll
     * @covers  CollectionType\Collection\CollectionSet\TreeSet::sort
     * @covers  CollectionType\Collection\CollectionSet\TreeSet::__construct
     * @covers  CollectionType\Collection\CollectionSet\SetAbstract::addAll
     * @covers  CollectionType\Collection\CollectionSet\SetAbstract::contains
     * @covers  CollectionType\Collection\CollectionSet\SetAbstract::validateValueForValueType
     */
    public function testAddAllForFilledBaseSet()
    {
        $value8 = '8';
        $this->dummyType->isValid($value8)->willReturn(true);
        $this->set->add($value8);

        $value7 = '7';
        $this->dummyType->isValid($value7)->willReturn(true);
        $this->set->add($value7);

        $otherSet = new HashSet($this->dummyType->reveal());

        $value3 = '3';
        $this->dummyType->isValid($value3)->willReturn(true);

        $otherSet->add($value3);

        $value2 = '2';
        $this->dummyType->isValid($value2)->willReturn(true);

        $otherSet->add($value2);

        $value4 = '4';
        $this->dummyType->isValid($value4)->willReturn(true);

        $otherSet->add($value4);

        $value1 = '1';
        $this->dummyType->isValid($value1)->willReturn(true);

        $otherSet->add($value1);

        $this->set->addAll($otherSet);

        $result = $this->set->getAll();

        $this->assertEquals([$value1, $value2, $value3, $value4, $value7, $value8], $result);
    }
}