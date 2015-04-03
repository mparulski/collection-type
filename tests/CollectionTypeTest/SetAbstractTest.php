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


use Fake\SetAbstractFake;

class SetAbstractTest extends \PHPUnit_Framework_TestCase
{
    /** @var \Fake\SetAbstractFake $set */
    private $set;

    private $dummyType;

    public function setUp()
    {
        $this->dummyType = $this->prophesize('CollectionType\Type\StringType');
        $this->dummyType->willImplement('CollectionType\Type\TypeInterface');

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
     * @covers       CollectionType\SetAbstract::addAll
     * @covers       CollectionType\SetAbstract::getType
     * @covers       CollectionType\ValueTypeTrait::getValueType
     */
    public function testAddAllForWrongTypeCollectionThrowException()
    {
        $dummy = $this->prophesize('CollectionType\Type\IntegerType');
        $dummy->willImplement('CollectionType\Type\TypeInterface');
        $intDummy = $dummy->reveal();
        $intCollection = new SetAbstractFake($intDummy);

        $this->set->addAll($intCollection);
    }

    /**
     * @covers       CollectionType\SetAbstract::addAll
     * @covers       CollectionType\CollectionTypeUtilTrait::twoArraysDiff
     */
    public function testAddAllForEmptyAndEmpty()
    {
        $addedCollection = clone $this->set;
        $this->set->addAll($addedCollection);

        $this->assertEquals([], $this->set->getAll());
    }

    /**
     * @covers       CollectionType\SetAbstract::addAll
     * @covers       CollectionType\CollectionTypeUtilTrait::twoArraysDiff
     */
    public function testAddAllForDifferentValues()
    {
        $addedCollection = clone $this->set;

        $this->set->add('A');
        $this->set->add('B');
        $this->set->add('C');

        $addedCollection->add('A');
        $addedCollection->add('D');
        $addedCollection->add('E');

        $this->set->addAll($addedCollection);

        $this->assertEquals(['A', 'B', 'C', 'D', 'E'], $this->set->getAll());
    }
}