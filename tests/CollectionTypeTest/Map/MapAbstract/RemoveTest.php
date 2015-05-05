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

namespace CollectionTypeTest\Map\MapAbstract;

use Fake\Map\MapAbstractFake;

class RemoveTest extends \PHPUnit_Framework_TestCase
{
    /** @var \Fake\Map\MapAbstractFake $map */
    private $map;

    private $dummyKeyType;

    private $dummyValueType;

    public function setUp()
    {
        $this->dummyKeyType = $this->prophesize('CollectionType\TypeValidator\StringTypeValidator');
        $this->dummyKeyType->willImplement('CollectionType\TypeValidator\TypeValidatorInterface');

        $this->dummyValueType = $this->prophesize('CollectionType\TypeValidator\StringTypeValidator');
        $this->dummyValueType->willImplement('CollectionType\TypeValidator\TypeValidatorInterface');

        $this->map = new MapAbstractFake($this->dummyKeyType->reveal(), $this->dummyValueType->reveal());
    }

    public function tearDown()
    {
        $this->map = null;
        $this->dummyType = null;
    }

    /**
     * @expectedException \CollectionType\Exception\InvalidTypeException
     *
     * @covers       CollectionType\Map\MapAbstract::remove
     * @covers       CollectionType\Map\MapAbstract::validateValueForKeyType
     * @covers       CollectionType\Map\MapAbstract::__construct
     */
    public function testRemoveForIncorrectKeyType()
    {
        $key = 1;
        $this->dummyKeyType->isValid($key)->willReturn(false);

        $this->map->remove($key);
    }

    /**
     * @covers       CollectionType\Map\MapAbstract::remove
     * @covers       CollectionType\Map\MapAbstract::validateValueForKeyType
     * @covers       CollectionType\Map\MapAbstract::containsKey
     * @covers       CollectionType\Map\MapAbstract::__construct
     */
    public function testRemoveNotContainRemovedKey()
    {
        $key = '1';
        $this->dummyKeyType->isValid($key)->willReturn(true);

        $result = $this->map->remove($key);

        $this->assertFalse($result);
    }

    /**
     * @covers       CollectionType\Map\MapAbstract::remove
     * @covers       CollectionType\Map\MapAbstract::validateValueForKeyType
     * @covers       CollectionType\Map\MapAbstract::containsKey
     * @covers       CollectionType\Map\MapAbstract::isSynchronizedIndex
     * @covers       CollectionType\Map\MapAbstract::__construct
     */
    public function testRemoveWhenContainRemovedKey()
    {
        $key1 = '1';
        $this->dummyKeyType->isValid($key1)->willReturn(true);
        $value1 = '1';
        $this->dummyValueType->isValid($value1)->willReturn(true);
        $this->map->put($key1, $value1);

        $key2 = '2';
        $this->dummyKeyType->isValid($key2)->willReturn(true);
        $value2 = '2';
        $this->dummyValueType->isValid($value2)->willReturn(true);
        $this->map->put($key2, $value2);

        $key3 = '3';
        $this->dummyKeyType->isValid($key3)->willReturn(true);
        $value3 = '3';
        $this->dummyValueType->isValid($value3)->willReturn(true);
        $this->map->put($key3, $value3);

        $result = $this->map->remove($key2);

        $this->assertTrue($result);
    }

    /**
     * @covers       CollectionType\Map\MapAbstract::remove
     * @covers       CollectionType\Map\MapAbstract::validateValueForKeyType
     * @covers       CollectionType\Map\MapAbstract::containsKey
     * @covers       CollectionType\Map\MapAbstract::isSynchronizedIndex
     * @covers       CollectionType\Map\MapAbstract::__construct
     */
    public function testRemoveForReturnKeys()
    {
        $key1 = '1';
        $this->dummyKeyType->isValid($key1)->willReturn(true);
        $value1 = '1';
        $this->dummyValueType->isValid($value1)->willReturn(true);
        $this->map->put($key1, $value1);

        $key2 = '2';
        $this->dummyKeyType->isValid($key2)->willReturn(true);
        $value2 = '2';
        $this->dummyValueType->isValid($value2)->willReturn(true);
        $this->map->put($key2, $value2);

        $key3 = '3';
        $this->dummyKeyType->isValid($key3)->willReturn(true);
        $value3 = '3';
        $this->dummyValueType->isValid($value3)->willReturn(true);
        $this->map->put($key3, $value3);

        $this->map->remove($key2);

        $result = $this->map->keys();

        $this->assertEquals(['1', '3'], $result);
    }

    /**
     * @covers       CollectionType\Map\MapAbstract::remove
     * @covers       CollectionType\Map\MapAbstract::validateValueForKeyType
     * @covers       CollectionType\Map\MapAbstract::containsKey
     * @covers       CollectionType\Map\MapAbstract::isSynchronizedIndex
     * @covers       CollectionType\Map\MapAbstract::__construct
     */
    public function testRemoveForReturnValues()
    {
        $key1 = '1';
        $this->dummyKeyType->isValid($key1)->willReturn(true);
        $value1 = '1';
        $this->dummyValueType->isValid($value1)->willReturn(true);
        $this->map->put($key1, $value1);

        $key2 = '2';
        $this->dummyKeyType->isValid($key2)->willReturn(true);
        $value2 = '2';
        $this->dummyValueType->isValid($value2)->willReturn(true);
        $this->map->put($key2, $value2);

        $key3 = '3';
        $this->dummyKeyType->isValid($key3)->willReturn(true);
        $value3 = '3';
        $this->dummyValueType->isValid($value3)->willReturn(true);
        $this->map->put($key3, $value3);

        $this->map->remove($key2);

        $result = $this->map->values();

        $this->assertEquals(['1', '3'], $result);
    }

    /**
     * @expectedException \CollectionType\Exception\SynchronizeException
     *
     * @covers       CollectionType\Map\MapAbstract::remove
     * @covers       CollectionType\Map\MapAbstract::validateValueForKeyType
     * @covers       CollectionType\Map\MapAbstract::containsKey
     * @covers       CollectionType\Map\MapAbstract::isSynchronizedIndex
     * @covers       CollectionType\Map\MapAbstract::__construct
     */
    public function testRemoveForNotSynchronizedMap()
    {
        $key1 = '1';
        $this->dummyKeyType->isValid($key1)->willReturn(true);
        $value1 = '1';
        $this->dummyValueType->isValid($value1)->willReturn(true);
        $this->map->put($key1, $value1);

        /** fake method, only for UnitTests */
        $this->map->putKey('2');

        $this->map->remove($key1);
    }
}
