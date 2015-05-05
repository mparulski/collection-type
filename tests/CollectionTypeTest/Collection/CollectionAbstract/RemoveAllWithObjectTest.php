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

class RemoveAllWithObjectTest extends \PHPUnit_Framework_TestCase
{
    /** @var \Fake\Collection\CollectionAbstractFake $collection */
    private $collection;

    private $dummyType;

    public function setUp()
    {
        $this->dummyType = $this->prophesize('CollectionType\TypeValidator\ObjectTypeValidator');
        $this->dummyType->willImplement('CollectionType\TypeValidator\TypeValidatorInterface');

        $this->collection = new CollectionAbstractFake($this->dummyType->reveal());
    }

    public function tearDown()
    {
        $this->collection = null;
        $this->dummyType = null;
    }

    /**
     * @covers       CollectionType\Collection\CollectionAbstract::removeAll
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
     * @covers       CollectionType\Collection\CollectionAbstract::removeAll
     * @covers       CollectionType\Common\Util\UtilTrait::equalArrays
     * @covers       CollectionType\Common\Util\UtilTrait::diffArrays
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
     * @covers       CollectionType\Collection\CollectionAbstract::removeAll
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
}