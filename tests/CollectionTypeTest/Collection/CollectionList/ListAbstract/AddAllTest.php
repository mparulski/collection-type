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

namespace CollectionTypeTest\Collection\CollectionList\ListAbstract;

use Fake\Collection\CollectionList\ListAbstractFake;

class AddAllTest extends \PHPUnit_Framework_TestCase
{
    /** @var \Fake\Collection\CollectionList\ListAbstractFake $list */
    private $list;

    private $dummyType;

    public function setUp()
    {
        $this->dummyType = $this->prophesize('CollectionType\TypeValidator\StringTypeValidator');
        $this->dummyType->willImplement('CollectionType\TypeValidator\TypeValidatorInterface');

        $this->list = new ListAbstractFake($this->dummyType->reveal());
    }

    public function tearDown()
    {
        $this->list = null;
        $this->dummyType = null;
    }

    /**
     * @expectedException \CollectionType\Exception\InvalidTypeException
     *
     * @covers       CollectionType\Collection\CollectionList\ListAbstract::addAll
     */
    public function testAddAllForWrongTypeCollectionThrowException()
    {
        $dummy = $this->prophesize('CollectionType\TypeValidator\IntegerTypeValidator');
        $dummy->willImplement('CollectionType\TypeValidator\TypeValidatorInterface');
        $intDummy = $dummy->reveal();
        $intCollection = new ListAbstractFake($intDummy);

        $this->list->addAll($intCollection);
    }

    /**
     * @covers       CollectionType\Collection\CollectionList\ListAbstract::addAll
     */
    public function testAddAllForEmptyAndEmpty()
    {
        $addedCollection = clone $this->list;
        $this->list->addAll($addedCollection);

        $this->assertEquals([], $this->list->getAll());
    }

    /**
     * @covers       CollectionType\Collection\CollectionList\ListAbstract::addAll
     */
    public function testAddAllForDifferentValues()
    {
        $addedCollection = clone $this->list;

        $valueA = 'A';
        $valueB = 'B';
        $valueC = 'C';
        $valueD = 'D';
        $valueE = 'E';

        $this->dummyType->isValid($valueA)->willReturn(true);
        $this->list->add($valueA);
        $this->dummyType->isValid($valueB)->willReturn(true);
        $this->list->add($valueB);
        $this->dummyType->isValid($valueC)->willReturn(true);
        $this->list->add($valueC);

        $this->dummyType->isValid($valueD)->willReturn(true);
        $addedCollection->add($valueD);
        $this->dummyType->isValid($valueE)->willReturn(true);
        $addedCollection->add($valueE);

        $this->list->addAll($addedCollection);

        $this->assertEquals(['A', 'B', 'C', 'D', 'E'], $this->list->getAll());
    }
}