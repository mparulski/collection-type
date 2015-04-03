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


use Fake\CollectionAbstractFake;

class CollectionAbstractForObjectTest extends \PHPUnit_Framework_TestCase
{
    /** @var \Fake\CollectionAbstractFake $collection */
    private $collection;

    private $dummyType;

    public function setUp()
    {
        $this->dummyType = $this->prophesize('CollectionType\Type\ObjectType');
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
    public function testGetAllForFewValues()
    {
        $a = new \stdClass();
        $a->param = 'A';
        $b = new \stdClass();
        $b->param = 'B';
        $c = new \stdClass();
        $c->param = 'C';
        $d = new \stdClass();
        $d->param = 'D';
        $e = new \stdClass();
        $e->param = 'E';

        $this->collection->add($a);
        $this->collection->add($b);
        $this->collection->add($c);
        $this->collection->add($d);
        $this->collection->add($e);

        $result = $this->collection->getAll();

        $this->assertEquals([$a, $b, $c, $d, $e], $result);
    }

    /**
     * @covers       CollectionType\CollectionAbstract::toArray
     */
    public function testToArrayForSomeValues()
    {
        $a = new \stdClass();
        $a->param = 'A';
        $b = new \stdClass();
        $b->param = 'B';
        $c = new \stdClass();
        $c->param = 'C';

        $this->collection->add($a);
        $this->collection->add($b);
        $this->collection->add($c);

        $result = $this->collection->toArray();
        $this->assertEquals([$a, $b, $c], $result);
    }

    /**
     * @covers       CollectionType\CollectionAbstract::removeAll
     */
    public function testRemoveAllWhenDoNotContainValue()
    {
        $a = new \stdClass();
        $a->param = 'A';
        $b = new \stdClass();
        $b->param = 'B';
        $c = new \stdClass();
        $c->param = 'C';
        $d = new \stdClass();
        $d->param = 'D';
        $e = new \stdClass();
        $e->param = 'E';

        $someCollection = clone $this->collection;

        $this->collection->add($a);
        $this->collection->add($b);
        $this->collection->add($c);

        $someCollection->add($d);
        $someCollection->add($e);

        $result = $this->collection->removeAll($someCollection);

        $this->assertFalse($result);
    }

    /**
     * @covers       CollectionType\CollectionAbstract::removeAll
     */
    public function testRemoveAllWhenContainValue()
    {
        $a = new \stdClass();
        $a->param = 'A';
        $b = new \stdClass();
        $b->param = 'B';
        $c = new \stdClass();
        $c->param = 'C';

        $someCollection = clone $this->collection;
        $someCollection->add($a);

        $this->dummyType->isValid($a)->willReturn(true);

        $this->collection->add($a);
        $this->collection->add($b);
        $this->collection->add($c);

        $result = $this->collection->removeAll($someCollection);

        $this->assertTrue($result);
    }

    /**
     * @covers       CollectionType\CollectionAbstract::removeAll
     */
    public function testRemoveAllWhenContainValueAfterRemove()
    {
        $a = new \stdClass();
        $a->param = 'A';
        $b = new \stdClass();
        $b->param = 'B';
        $c = new \stdClass();
        $c->param = 'C';

        $someCollection = clone $this->collection;
        $someCollection->add($a);

        $this->dummyType->isValid($a)->willReturn(true);

        $this->collection->add($a);
        $this->collection->add($b);
        $this->collection->add($c);

        $this->collection->removeAll($someCollection);

        $result = $this->collection->getAll();

        $this->assertEquals([$b, $c], $result);
    }

    /**
     * @covers       CollectionType\CollectionAbstract::containsAll
     */
    public function testContainsAllWhenDoNotContainValue()
    {
        $a = new \stdClass();
        $a->param = 'A';
        $b = new \stdClass();
        $b->param = 'B';
        $c = new \stdClass();
        $c->param = 'C';
        $e = new \stdClass();
        $e->param = 'E';

        $someCollection = clone $this->collection;
        $someCollection->add($a);
        $someCollection->add($e);

        $this->collection->add($a);
        $this->collection->add($b);
        $this->collection->add($c);

        $result = $this->collection->containsAll($someCollection);

        $this->assertFalse($result);
    }

    /**
     * @covers       CollectionType\CollectionAbstract::containsAll
     */
    public function testContainsAllWhenContainValue()
    {
        $a = new \stdClass();
        $a->param = 'A';
        $b = new \stdClass();
        $b->param = 'B';
        $c = new \stdClass();
        $c->param = 'C';

        $someCollection = clone $this->collection;
        $someCollection->add($a);
        $someCollection->add($c);

        $this->collection->add($a);
        $this->collection->add($b);
        $this->collection->add($c);

        $result = $this->collection->containsAll($someCollection);

        $this->assertTrue($result);
    }

    /**
     * @covers       CollectionType\CollectionAbstract::remove
     * @covers       CollectionType\CollectionAbstract::contains
     */
    public function testRemoveWhenDoNotContainValue()
    {
        $a = new \stdClass();
        $a->param = 'A';
        $b = new \stdClass();
        $b->param = 'B';
        $c = new \stdClass();
        $c->param = 'C';
        $e = new \stdClass();
        $e->param = 'E';

        $this->collection->add($a);
        $this->collection->add($b);
        $this->collection->add($c);

        $this->dummyType->isValid($e)->willReturn(true);

        $result = $this->collection->remove($e);

        $this->assertFalse($result);
    }

    /**
     * @covers       CollectionType\CollectionAbstract::remove
     * @covers       CollectionType\CollectionAbstract::contains
     */
    public function testRemoveWhenContainValue()
    {
        $a = new \stdClass();
        $a->param = 'A';
        $b = new \stdClass();
        $b->param = 'B';
        $c = new \stdClass();
        $c->param = 'C';

        $this->collection->add($a);
        $this->collection->add($b);
        $this->collection->add($c);

        $this->dummyType->isValid($b)->willReturn(true);

        $result = $this->collection->remove($b);

        $this->assertTrue($result);
    }

    /**
     * @covers       CollectionType\CollectionAbstract::remove
     * @covers       CollectionType\CollectionAbstract::contains
     */
    public function testRemoveForCheckingValuesAfterRemove()
    {
        $a = new \stdClass();
        $a->param = 'A';
        $b = new \stdClass();
        $b->param = 'B';
        $c = new \stdClass();
        $c->param = 'C';

        $this->collection->add($a);
        $this->collection->add($b);
        $this->collection->add($c);

        $this->dummyType->isValid($b)->willReturn(true);

        $this->collection->remove($b);

        $result = $this->collection->getAll();

        $this->assertEquals([$a, $c], $result);
    }

    /**
     * @covers       CollectionType\CollectionAbstract::contains
     */
    public function testContainsForNotContainValue()
    {
        $a = new \stdClass();
        $a->param = 'A';
        $b = new \stdClass();
        $b->param = 'B';
        $c = new \stdClass();
        $c->param = 'C';
        $e = new \stdClass();
        $e->param = 'E';

        $this->collection->add($a);
        $this->collection->add($b);
        $this->collection->add($c);

        $this->dummyType->isValid($e)->willReturn(true);

        $result = $this->collection->contains($e);

        $this->assertFalse($result);
    }

    /**
     * @covers       CollectionType\CollectionAbstract::contains
     */
    public function testContainsForContainValue()
    {
        $a = new \stdClass();
        $a->param = 'A';
        $b = new \stdClass();
        $b->param = 'B';
        $c = new \stdClass();
        $c->param = 'C';

        $this->collection->add($a);
        $this->collection->add($b);
        $this->collection->add($c);

        $this->dummyType->isValid($b)->willReturn(true);

        $result = $this->collection->contains($b);

        $this->assertTrue($result);
    }

    /**
     * @covers       CollectionType\CollectionAbstract::equals
     */
    public function testEqualsForDifferentCollectionsValues()
    {
        $a = new \stdClass();
        $a->param = 'A';
        $b = new \stdClass();
        $b->param = 'B';
        $c = new \stdClass();
        $c->param = 'C';
        $d = new \stdClass();
        $d->param = 'D';
        $e = new \stdClass();
        $e->param = 'E';

        $someCollection = clone $this->collection;

        $this->collection->add($a);
        $this->collection->add($b);
        $this->collection->add($c);

        $someCollection->add($d);
        $someCollection->add($e);

        $result = $this->collection->equals($someCollection);

        $this->assertFalse($result);
    }

    /**
     * @covers       CollectionType\CollectionAbstract::equals
     * @covers       CollectionType\CollectionTypeUtilTrait::twoArraysDiff
     */
    public function testEqualsForTheSameCollections()
    {
        $a = new \stdClass();
        $a->param = 'A';
        $b = new \stdClass();
        $b->param = 'B';
        $c = new \stdClass();
        $c->param = 'C';

        $someCollection = clone $this->collection;

        $this->collection->add($a);
        $this->collection->add($a);
        $this->collection->add($c);

        $someCollection->add($a);
        $someCollection->add($b);
        $someCollection->add($c);

        $result = $this->collection->equals($someCollection);

        $this->assertTrue($result);
    }
}