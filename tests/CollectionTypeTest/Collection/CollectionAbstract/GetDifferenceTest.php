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

namespace CollectionTypeTest\Collection\CollectionAbstract;

use Fake\Collection\CollectionAbstractFake;

class GetDifferenceTest extends \PHPUnit_Framework_TestCase
{
    /** @var \Fake\Collection\CollectionAbstractFake $collection */
    private $collection;

    private $dummyType;

    public function setUp()
    {
        $this->dummyType = $this->prophesize('CollectionType\TypeValidator\StringTypeValidator');
        $this->dummyType->willImplement('CollectionType\TypeValidator\TypeValidatorInterface');

        $this->collection = new CollectionAbstractFake($this->dummyType->reveal());
    }

    public function tearDown()
    {
        $this->collection = null;
        $this->dummyType = null;
    }

    /**
     * @expectedException \CollectionType\Exception\InvalidTypeException
     *
     * @covers       CollectionType\Collection\CollectionAbstract::getDifference
     */
    public function testGetDifferenceForDifferentValueType()
    {
        $this->collection->add('A');
        $this->collection->add('B');
        $this->collection->add('C');

        $dummyType = $this->prophesize('CollectionType\TypeValidator\IntegerTypeValidator');
        $dummyType->willImplement('CollectionType\TypeValidator\TypeValidatorInterface');

        $someCollection = new CollectionAbstractFake($dummyType->reveal());

        $someCollection->add(1);
        $someCollection->add(2);

        $this->collection->getDifference($someCollection);
    }

    /**
     * @covers       CollectionType\Collection\CollectionAbstract::getDifference
     */
    public function testGetDifferenceWhenDoNotContainAllValues()
    {
        $valueA = 'A';
        $this->dummyType->isValid($valueA)->willReturn(true);
        $valueB = 'B';
        $this->dummyType->isValid($valueB)->willReturn(true);
        $valueC = 'C';
        $this->dummyType->isValid($valueC)->willReturn(true);
        $valueX = 'X';
        $this->dummyType->isValid($valueX)->willReturn(true);

        $someCollection = clone $this->collection;
        $someCollection->add($valueA);
        $someCollection->add($valueX);

        $this->collection->add($valueA);
        $this->collection->add($valueB);
        $this->collection->add($valueC);

        $result = $this->collection->getDifference($someCollection);

        $this->assertEquals([$valueB, $valueC], $result->getAll());
    }

    /**
     * @covers       CollectionType\Collection\CollectionAbstract::getDifference
     */
    public function testGetDifferenceWhenContainSomeValues()
    {
        $valueA = 'A';
        $this->dummyType->isValid($valueA)->willReturn(true);
        $valueB = 'B';
        $this->dummyType->isValid($valueB)->willReturn(true);
        $valueC = 'C';
        $this->dummyType->isValid($valueC)->willReturn(true);

        $someCollection = clone $this->collection;
        $someCollection->add($valueA);
        $someCollection->add($valueC);

        $this->collection->add($valueA);
        $this->collection->add($valueB);
        $this->collection->add($valueC);

        $result = $this->collection->getDifference($someCollection);

        $this->assertEquals([$valueB], $result->getAll());
    }

    /**
     * @covers       CollectionType\Collection\CollectionAbstract::getDifference
     */
    public function testGetDifferenceWhenContainAllValues()
    {
        $valueA = 'A';
        $this->dummyType->isValid($valueA)->willReturn(true);
        $valueB = 'B';
        $this->dummyType->isValid($valueB)->willReturn(true);
        $valueC = 'C';
        $this->dummyType->isValid($valueC)->willReturn(true);

        $someCollection = clone $this->collection;
        $someCollection->add($valueA);
        $someCollection->add($valueB);
        $someCollection->add($valueC);

        $this->collection->add($valueA);
        $this->collection->add($valueB);
        $this->collection->add($valueC);

        $result = $this->collection->getDifference($someCollection);

        $this->assertEquals([], $result->getAll());
    }
}