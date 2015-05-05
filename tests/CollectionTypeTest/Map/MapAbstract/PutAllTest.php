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

class PutAllTest extends \PHPUnit_Framework_TestCase
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
     * @covers       CollectionType\Map\MapAbstract::putAll
     * @covers       CollectionType\Map\MapAbstract::isSynchronizedKeyAndValue
     * @covers       CollectionType\Map\MapAbstract::__construct
     * @covers       CollectionType\Common\KeyTypeTrait::validateValueForKeyType
     * @covers       CollectionType\Common\KeyTypeTrait::getKeyType
     * @covers       CollectionType\Common\ValueTypeTrait::validateValueForValueType
     */
    public function testPutAllForDifferentKeyType()
    {
        $dummyKeyType = $this->prophesize('CollectionType\TypeValidator\IntegerTypeValidator');
        $dummyKeyType->willImplement('CollectionType\TypeValidator\TypeValidatorInterface');

        $otherMap = new MapAbstractFake($dummyKeyType->reveal(), $this->dummyValueType->reveal());

        $this->map->putAll($otherMap);
    }

    /**
     * @expectedException \CollectionType\Exception\InvalidTypeException
     *
     * @covers       CollectionType\Map\MapAbstract::putAll
     * @covers       CollectionType\Map\MapAbstract::isSynchronizedKeyAndValue
     * @covers       CollectionType\Map\MapAbstract::__construct
     * @covers       CollectionType\Common\KeyTypeTrait::validateValueForKeyType
     * @covers       CollectionType\Common\KeyTypeTrait::getKeyType
     * @covers       CollectionType\Common\ValueTypeTrait::validateValueForValueType
     */
    public function testPutAllForDifferentValueType()
    {
        $dummyValueType = $this->prophesize('CollectionType\TypeValidator\IntegerTypeValidator');
        $dummyValueType->willImplement('CollectionType\TypeValidator\TypeValidatorInterface');

        $otherMap = new MapAbstractFake($this->dummyKeyType->reveal(), $dummyValueType->reveal());

        $this->map->putAll($otherMap);
    }

    /**
     * @covers       CollectionType\Map\MapAbstract::putAll
     * @covers       CollectionType\Map\MapAbstract::isSynchronizedKeyAndValue
     * @covers       CollectionType\Map\MapAbstract::__construct
     * @covers       CollectionType\Common\KeyTypeTrait::validateValueForKeyType
     * @covers       CollectionType\Common\KeyTypeTrait::getKeyType
     * @covers       CollectionType\Common\ValueTypeTrait::validateValueForValueType
     */
    public function testPutAllToEmptyMap()
    {
        $otherMap = new MapAbstractFake($this->dummyKeyType->reveal(), $this->dummyValueType->reveal());

        $key1 = '1';
        $value1 = '1';
        $this->dummyKeyType->isValid($key1)->willReturn(true);
        $this->dummyValueType->isValid($value1)->willReturn(true);
        $otherMap->put($key1, $value1);

        $key2 = '2';
        $value2 = '2';
        $this->dummyKeyType->isValid($key2)->willReturn(true);
        $this->dummyValueType->isValid($value2)->willReturn(true);
        $otherMap->put($key2, $value2);

        $key3 = '3';
        $value3 = '3';
        $this->dummyKeyType->isValid($key3)->willReturn(true);
        $this->dummyValueType->isValid($value3)->willReturn(true);
        $otherMap->put($key3, $value3);

        $result = $this->map->putAll($otherMap);

        $this->assertTrue($result);
    }

    /**
     * @covers       CollectionType\Map\MapAbstract::putAll
     * @covers       CollectionType\Map\MapAbstract::isSynchronizedKeyAndValue
     * @covers       CollectionType\Map\MapAbstract::__construct
     * @covers       CollectionType\Common\KeyTypeTrait::validateValueForKeyType
     * @covers       CollectionType\Common\KeyTypeTrait::getKeyType
     * @covers       CollectionType\Common\ValueTypeTrait::validateValueForValueType
     */
    public function testPutAllToEmptyMapForValidateKeys()
    {
        $otherMap = new MapAbstractFake($this->dummyKeyType->reveal(), $this->dummyValueType->reveal());

        $key1 = '1';
        $value1 = '1';
        $this->dummyKeyType->isValid($key1)->willReturn(true);
        $this->dummyValueType->isValid($value1)->willReturn(true);
        $otherMap->put($key1, $value1);

        $key2 = '2';
        $value2 = '2';
        $this->dummyKeyType->isValid($key2)->willReturn(true);
        $this->dummyValueType->isValid($value2)->willReturn(true);
        $otherMap->put($key2, $value2);

        $key3 = '3';
        $value3 = '3';
        $this->dummyKeyType->isValid($key3)->willReturn(true);
        $this->dummyValueType->isValid($value3)->willReturn(true);
        $otherMap->put($key3, $value3);

        $this->map->putAll($otherMap);
        $result = $this->map->keys();

        $this->assertEquals(['1', '2', '3'], $result);
    }

    /**
     * @covers       CollectionType\Map\MapAbstract::putAll
     * @covers       CollectionType\Map\MapAbstract::isSynchronizedKeyAndValue
     * @covers       CollectionType\Map\MapAbstract::__construct
     * @covers       CollectionType\Common\KeyTypeTrait::validateValueForKeyType
     * @covers       CollectionType\Common\KeyTypeTrait::getKeyType
     * @covers       CollectionType\Common\ValueTypeTrait::validateValueForValueType
     */
    public function testPutAllToEmptyMapForValidateValues()
    {
        $otherMap = new MapAbstractFake($this->dummyKeyType->reveal(), $this->dummyValueType->reveal());

        $key1 = '1';
        $value1 = '1';
        $this->dummyKeyType->isValid($key1)->willReturn(true);
        $this->dummyValueType->isValid($value1)->willReturn(true);
        $otherMap->put($key1, $value1);

        $key2 = '2';
        $value2 = '2';
        $this->dummyKeyType->isValid($key2)->willReturn(true);
        $this->dummyValueType->isValid($value2)->willReturn(true);
        $otherMap->put($key2, $value2);

        $key3 = '3';
        $value3 = '3';
        $this->dummyKeyType->isValid($key3)->willReturn(true);
        $this->dummyValueType->isValid($value3)->willReturn(true);
        $otherMap->put($key3, $value3);

        $this->map->putAll($otherMap);
        $result = $this->map->values();

        $this->assertEquals(['1', '2', '3'], $result);
    }

    /**
     * @covers       CollectionType\Map\MapAbstract::putAll
     * @covers       CollectionType\Map\MapAbstract::isSynchronizedKeyAndValue
     * @covers       CollectionType\Map\MapAbstract::__construct
     * @covers       CollectionType\Common\KeyTypeTrait::validateValueForKeyType
     * @covers       CollectionType\Common\KeyTypeTrait::getKeyType
     * @covers       CollectionType\Common\ValueTypeTrait::validateValueForValueType
     */
    public function testPutAllToFilledMapForValidateKeys()
    {
        $otherMap = new MapAbstractFake($this->dummyKeyType->reveal(), $this->dummyValueType->reveal());

        $key1 = 'base';
        $value1 = 'new';
        $this->dummyKeyType->isValid($key1)->willReturn(true);
        $this->dummyValueType->isValid($value1)->willReturn(true);
        $otherMap->put($key1, $value1);

        $key2 = '2';
        $value2 = '2';
        $this->dummyKeyType->isValid($key2)->willReturn(true);
        $this->dummyValueType->isValid($value2)->willReturn(true);
        $otherMap->put($key2, $value2);

        $key3 = '3';
        $value3 = '3';
        $this->dummyKeyType->isValid($key3)->willReturn(true);
        $this->dummyValueType->isValid($value3)->willReturn(true);
        $otherMap->put($key3, $value3);

        $key0 = '0';
        $value0 = '0';
        $this->dummyKeyType->isValid($key0)->willReturn(true);
        $this->dummyValueType->isValid($value0)->willReturn(true);
        $this->map->put($key0, $value0);

        $key1 = 'base';
        $value1 = 'old';
        $this->dummyKeyType->isValid($key1)->willReturn(true);
        $this->dummyValueType->isValid($value1)->willReturn(true);
        $this->map->put($key1, $value1);

        $this->map->putAll($otherMap);
        $result = $this->map->keys();

        $this->assertEquals(['0', 'base', '2', '3'], $result);
    }

    /**
     * @covers       CollectionType\Map\MapAbstract::putAll
     * @covers       CollectionType\Map\MapAbstract::isSynchronizedKeyAndValue
     * @covers       CollectionType\Map\MapAbstract::__construct
     * @covers       CollectionType\Common\KeyTypeTrait::validateValueForKeyType
     * @covers       CollectionType\Common\KeyTypeTrait::getKeyType
     * @covers       CollectionType\Common\ValueTypeTrait::validateValueForValueType
     */
    public function testPutAllToFilledMapForValidateValues()
    {
        $otherMap = new MapAbstractFake($this->dummyKeyType->reveal(), $this->dummyValueType->reveal());

        $key1 = 'base';
        $value1 = 'new';
        $this->dummyKeyType->isValid($key1)->willReturn(true);
        $this->dummyValueType->isValid($value1)->willReturn(true);
        $otherMap->put($key1, $value1);

        $key2 = '2';
        $value2 = '2';
        $this->dummyKeyType->isValid($key2)->willReturn(true);
        $this->dummyValueType->isValid($value2)->willReturn(true);
        $otherMap->put($key2, $value2);

        $key3 = '3';
        $value3 = '3';
        $this->dummyKeyType->isValid($key3)->willReturn(true);
        $this->dummyValueType->isValid($value3)->willReturn(true);
        $otherMap->put($key3, $value3);

        $key0 = '0';
        $value0 = '0';
        $this->dummyKeyType->isValid($key0)->willReturn(true);
        $this->dummyValueType->isValid($value0)->willReturn(true);
        $this->map->put($key0, $value0);

        $key1 = 'base';
        $value1 = 'old';
        $this->dummyKeyType->isValid($key1)->willReturn(true);
        $this->dummyValueType->isValid($value1)->willReturn(true);
        $this->map->put($key1, $value1);

        $this->map->putAll($otherMap);
        $result = $this->map->values();

        $this->assertEquals(['0', 'new', '2', '3'], $result);
    }
}
