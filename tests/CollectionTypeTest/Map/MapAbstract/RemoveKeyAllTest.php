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

class RemoveKeyAllTest extends \PHPUnit_Framework_TestCase
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
     * @covers       CollectionType\Map\MapAbstract::removeKeyAll
     * @covers       CollectionType\Map\MapAbstract::containsKeyAll
     * @covers       CollectionType\Map\MapAbstract::validateKeyType
     * @covers       CollectionType\Map\MapAbstract::__construct
     */
    public function testRemoveValueForDifferentKeyType()
    {
        $dummyKeyType = $this->prophesize('CollectionType\TypeValidator\IntegerTypeValidator');
        $dummyKeyType->willImplement('CollectionType\TypeValidator\TypeValidatorInterface');

        $otherMap = new MapAbstractFake($dummyKeyType->reveal(), $this->dummyValueType->reveal());

        $this->map->removeKeyAll($otherMap);
    }

    /**
     * @expectedException \CollectionType\Exception\InvalidTypeException
     *
     * @covers       CollectionType\Map\MapAbstract::removeKeyAll
     * @covers       CollectionType\Map\MapAbstract::containsKeyAll
     * @covers       CollectionType\Map\MapAbstract::validateKeyType
     * @covers       CollectionType\Map\MapAbstract::validateValueType
     * @covers       CollectionType\Map\MapAbstract::__construct
     */
    public function testRemoveValueAllForDifferentValueType()
    {
        $dummyValueType = $this->prophesize('CollectionType\TypeValidator\IntegerTypeValidator');
        $dummyValueType->willImplement('CollectionType\TypeValidator\TypeValidatorInterface');

        $otherMap = new MapAbstractFake($this->dummyKeyType->reveal(), $dummyValueType->reveal());

        $this->map->removeKeyAll($otherMap);
    }

    /**
     * @covers       CollectionType\Map\MapAbstract::removeKeyAll
     * @covers       CollectionType\Map\MapAbstract::containsKeyAll
     * @covers       CollectionType\Map\MapAbstract::validateKeyType
     * @covers       CollectionType\Map\MapAbstract::validateValueType
     * @covers       CollectionType\Map\MapAbstract::__construct
     */
    public function testRemoveValueAllWhenMapNotContainRemovedValue()
    {
        $otherMap = new MapAbstractFake($this->dummyKeyType->reveal(), $this->dummyValueType->reveal());

        $key1 = '1';
        $value1 = '1';
        $this->dummyKeyType->isValid($key1)->willReturn(true);
        $this->dummyValueType->isValid($value1)->willReturn(true);
        $otherMap->put($key1, $value1);

        $result = $this->map->removeKeyAll($otherMap);

        $this->assertFalse($result);
    }

    /**
     * @covers       CollectionType\Map\MapAbstract::removeKeyAll
     * @covers       CollectionType\Map\MapAbstract::containsKeyAll
     * @covers       CollectionType\Map\MapAbstract::validateKeyType
     * @covers       CollectionType\Map\MapAbstract::validateValueType
     * @covers       CollectionType\Map\MapAbstract::__construct
     */
    public function testRemoveValueAllWhenMapContainsSomeElements()
    {
        $otherMap = new MapAbstractFake($this->dummyKeyType->reveal(), $this->dummyValueType->reveal());

        $key1 = '1';
        $value1 = '1';
        $this->dummyKeyType->isValid($key1)->willReturn(true);
        $this->dummyValueType->isValid($value1)->willReturn(true);
        $this->map->put($key1, $value1);
        $otherMap->put($key1, $value1);

        $key2 = '2';
        $value2 = '2';
        $this->dummyKeyType->isValid($key2)->willReturn(true);
        $this->dummyValueType->isValid($value2)->willReturn(true);
        $this->map->put($key2, $value2);
        $otherMap->put($key2, $value2);

        $key3 = '3';
        $value3 = '3';
        $this->dummyKeyType->isValid($key3)->willReturn(true);
        $this->dummyValueType->isValid($value3)->willReturn(true);
        $otherMap->put($key3, $value3);

        $result = $this->map->removeKeyAll($otherMap);

        $this->assertFalse($result);
    }

    /**
     * @covers       CollectionType\Map\MapAbstract::removeKeyAll
     * @covers       CollectionType\Map\MapAbstract::containsKeyAll
     * @covers       CollectionType\Map\MapAbstract::validateKeyType
     * @covers       CollectionType\Map\MapAbstract::validateValueType
     * @covers       CollectionType\Map\MapAbstract::__construct
     */
    public function testRemoveValueAllWhenMapContainsAllElements()
    {
        $otherMap = new MapAbstractFake($this->dummyKeyType->reveal(), $this->dummyValueType->reveal());

        $key1 = '1';
        $value1 = '1';
        $this->dummyKeyType->isValid($key1)->willReturn(true);
        $this->dummyValueType->isValid($value1)->willReturn(true);
        $this->map->put($key1, $value1);
        $otherMap->put($key1, $value1);

        $key2 = '2';
        $value2 = '2';
        $this->dummyKeyType->isValid($key2)->willReturn(true);
        $this->dummyValueType->isValid($value2)->willReturn(true);
        $this->map->put($key2, $value2);
        $otherMap->put($key2, $value2);

        $key3 = '3';
        $value3 = '3';
        $this->dummyKeyType->isValid($key3)->willReturn(true);
        $this->dummyValueType->isValid($value3)->willReturn(true);
        $this->map->put($key3, $value3);

        $result = $this->map->removeKeyAll($otherMap);

        $this->assertTrue($result);
    }

    /**
     * @covers       CollectionType\Map\MapAbstract::removeKeyAll
     * @covers       CollectionType\Map\MapAbstract::containsKeyAll
     * @covers       CollectionType\Map\MapAbstract::validateKeyType
     * @covers       CollectionType\Map\MapAbstract::validateValueType
     * @covers       CollectionType\Map\MapAbstract::__construct
     */
    public function testRemoveValueAllWhenMapContainsAllElementsForReturnedKeys()
    {
        $otherMap = new MapAbstractFake($this->dummyKeyType->reveal(), $this->dummyValueType->reveal());

        $key1 = '1';
        $value1 = '1';
        $this->dummyKeyType->isValid($key1)->willReturn(true);
        $this->dummyValueType->isValid($value1)->willReturn(true);
        $this->map->put($key1, $value1);
        $otherMap->put($key1, $value1);

        $key2 = '2';
        $value2 = '2';
        $this->dummyKeyType->isValid($key2)->willReturn(true);
        $this->dummyValueType->isValid($value2)->willReturn(true);
        $this->map->put($key2, $value2);
        $otherMap->put($key2, $value2);

        $key3 = '3';
        $value3 = '3';
        $this->dummyKeyType->isValid($key3)->willReturn(true);
        $this->dummyValueType->isValid($value3)->willReturn(true);
        $this->map->put($key3, $value3);

        $this->map->removeKeyAll($otherMap);

        $result = $this->map->keys();

        $this->assertEquals(['3'], $result);
    }

    /**
     * @covers       CollectionType\Map\MapAbstract::removeKeyAll
     * @covers       CollectionType\Map\MapAbstract::containsKeyAll
     * @covers       CollectionType\Map\MapAbstract::validateKeyType
     * @covers       CollectionType\Map\MapAbstract::validateValueType
     * @covers       CollectionType\Map\MapAbstract::__construct
     */
    public function testRemoveValueAllWhenMapContainsAllElementsForReturnedValues()
    {
        $otherMap = new MapAbstractFake($this->dummyKeyType->reveal(), $this->dummyValueType->reveal());

        $key1 = '1';
        $value1 = '1';
        $this->dummyKeyType->isValid($key1)->willReturn(true);
        $this->dummyValueType->isValid($value1)->willReturn(true);
        $this->map->put($key1, $value1);
        $otherMap->put($key1, $value1);

        $key2 = '2';
        $value2 = '2';
        $this->dummyKeyType->isValid($key2)->willReturn(true);
        $this->dummyValueType->isValid($value2)->willReturn(true);
        $this->map->put($key2, $value2);
        $otherMap->put($key2, $value2);

        $key3 = '3';
        $value3 = '3';
        $this->dummyKeyType->isValid($key3)->willReturn(true);
        $this->dummyValueType->isValid($value3)->willReturn(true);
        $this->map->put($key3, $value3);

        $this->map->removeKeyAll($otherMap);

        $result = $this->map->values();

        $this->assertEquals(['3'], $result);
    }
}
