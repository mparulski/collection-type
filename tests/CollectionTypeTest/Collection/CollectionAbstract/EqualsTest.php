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

class EqualsTest extends \PHPUnit_Framework_TestCase
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
     * @covers       CollectionType\Collection\CollectionAbstract::equals
     * @covers       CollectionType\Common\ValueTypeTrait::getValueType
     */
    public function testEqualsForDifferentCollectionsTypes()
    {
        $this->collection->add('A');
        $this->collection->add('B');
        $this->collection->add('C');

        $dummyType = $this->prophesize('CollectionType\TypeValidator\IntegerTypeValidator');
        $dummyType->willImplement('CollectionType\TypeValidator\TypeValidatorInterface');

        $someCollection = new CollectionAbstractFake($dummyType->reveal());

        $someCollection->add(1);
        $someCollection->add(2);

        $this->collection->equals($someCollection);
    }

    /**
     * @covers       CollectionType\Collection\CollectionAbstract::equals
     */
    public function testEqualsForDifferentCollectionsValues()
    {
        $someCollection = clone $this->collection;

        $this->collection->add('A');
        $this->collection->add('B');
        $this->collection->add('C');

        $someCollection->add('X');
        $someCollection->add('Y');
        $someCollection->add('Z');

        $result = $this->collection->equals($someCollection);

        $this->assertFalse($result);
    }

    /**
     * @covers       CollectionType\Collection\CollectionAbstract::equals
     */
    public function testEqualsForTheSameCollections()
    {
        $someCollection = clone $this->collection;

        $this->collection->add('A');
        $this->collection->add('B');
        $this->collection->add('C');

        $someCollection->add('A');
        $someCollection->add('B');
        $someCollection->add('C');

        $result = $this->collection->equals($someCollection);

        $this->assertTrue($result);
    }
}