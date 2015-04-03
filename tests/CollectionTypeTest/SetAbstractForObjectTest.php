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

class SetAbstractForObjectTest extends \PHPUnit_Framework_TestCase
{
    /** @var \Fake\SetAbstractFake $set */
    private $set;

    private $dummyType;

    public function setUp()
    {
        $this->dummyType = $this->prophesize('CollectionType\Type\ObjectType');
        $this->dummyType->willImplement('CollectionType\Type\TypeInterface');

        $this->set = new SetAbstractFake($this->dummyType->reveal());
    }

    public function tearDown()
    {
        $this->set = null;
        $this->dummyType = null;
    }

    /**
     * @covers       CollectionType\SetAbstract::addAll
     * @covers       CollectionType\CollectionTypeUtilTrait::twoArraysDiff
     */
    public function testAddAllForDifferentValues()
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
        $aa = new \stdClass();
        $aa->param = 'A';

        $addedCollection = clone $this->set;

        $this->set->add($a);
        $this->set->add($b);
        $this->set->add($c);

        $addedCollection->add($aa);
        $addedCollection->add($a);
        $addedCollection->add($d);
        $addedCollection->add($e);

        $this->set->addAll($addedCollection);

        $this->assertEquals([$a, $b, $c, $aa, $d, $e], $this->set->getAll());
    }
}