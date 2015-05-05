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

class SetAbstractForObjectTest extends \PHPUnit_Framework_TestCase
{
    /** @var \Fake\Collection\CollectionSet\SetAbstractFake $set */
    private $set;

    private $dummyType;

    private $objectA;

    private $objectB;

    private $objectC;

    private $objectD;

    private $objectE;

    public function setUp()
    {
        $this->dummyType = $this->prophesize('CollectionType\TypeValidator\ObjectTypeValidator');
        $this->dummyType->willImplement('CollectionType\TypeValidator\TypeValidatorInterface');

        $this->set = new SetAbstractFake($this->dummyType->reveal());

        $this->objectA = new \stdClass();
        $this->objectA->param = 'A';
        $this->objectB = new \stdClass();
        $this->objectB->param = 'B';
        $this->objectC = new \stdClass();
        $this->objectC->param = 'C';
        $this->objectD = new \stdClass();
        $this->objectD->param = 'D';
        $this->objectE = new \stdClass();
        $this->objectE->param = 'E';
    }

    public function tearDown()
    {
        $this->set = null;
        $this->dummyType = null;
    }

    /**
     * @covers       CollectionType\Collection\CollectionSet\SetAbstract::add
     * @covers       CollectionType\Collection\CollectionSet\SetAbstract::__construct
     */
    public function testAddForUnrepeatableValues()
    {
        $this->dummyType->isValid($this->objectA)->willReturn(true);
        $resultA = $this->set->add($this->objectA);

        $this->dummyType->isValid($this->objectB)->willReturn(true);
        $resultB = $this->set->add($this->objectB);

        $this->dummyType->isValid($this->objectC)->willReturn(true);
        $resultC = $this->set->add($this->objectC);

        $this->assertTrue($resultA && $resultB && $resultC);
    }

    /**
     * @covers       CollectionType\Collection\CollectionSet\SetAbstract::add
     * @covers       CollectionType\Collection\CollectionSet\SetAbstract::__construct
     */
    public function testAddForRepeatableValues()
    {
        $this->dummyType->isValid($this->objectA)->willReturn(true);
        $this->set->add($this->objectA);

        $this->dummyType->isValid($this->objectA)->willReturn(true);
        $result = $this->set->add($this->objectA);

        $this->assertFalse($result);
    }

    /**
     * @covers       CollectionType\Collection\CollectionSet\SetAbstract::addAll
     * @covers       CollectionType\Common\Util\UtilTrait::diffArrays
     */
    public function testAddAllForDifferentValues()
    {
        $aa = new \stdClass();
        $aa->param = 'A';

        $addedCollection = clone $this->set;

        $this->dummyType->isValid($this->objectA)->willReturn(true);
        $this->set->add($this->objectA);
        $this->dummyType->isValid($this->objectB)->willReturn(true);
        $this->set->add($this->objectB);
        $this->dummyType->isValid($this->objectC)->willReturn(true);
        $this->set->add($this->objectC);

        $this->dummyType->isValid($aa)->willReturn(true);
        $addedCollection->add($aa);
        $this->dummyType->isValid($this->objectA)->willReturn(true);
        $addedCollection->add($this->objectA);
        $this->dummyType->isValid($this->objectD)->willReturn(true);
        $addedCollection->add($this->objectD);
        $this->dummyType->isValid($this->objectE)->willReturn(true);
        $addedCollection->add($this->objectE);

        $this->set->addAll($addedCollection);

        $this->assertEquals([$this->objectA, $this->objectB, $this->objectC, $aa, $this->objectD, $this->objectE],
            $this->set->getAll());
    }
}