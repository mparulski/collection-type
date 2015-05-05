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

class PutAllWithObjectTest extends \PHPUnit_Framework_TestCase
{
    /** @var \Fake\Map\MapAbstractFake $map */
    private $map;

    private $dummyKeyType;

    private $dummyValueType;

    public function setUp()
    {
        $this->dummyKeyType = $this->prophesize('CollectionType\TypeValidator\ObjectTypeValidator');
        $this->dummyKeyType->willImplement('CollectionType\TypeValidator\TypeValidatorInterface');

        $this->dummyValueType = $this->prophesize('CollectionType\TypeValidator\ObjectTypeValidator');
        $this->dummyValueType->willImplement('CollectionType\TypeValidator\TypeValidatorInterface');

        $this->map = new MapAbstractFake($this->dummyKeyType->reveal(), $this->dummyValueType->reveal());
    }

    public function tearDown()
    {
        $this->map = null;
        $this->dummyType = null;
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

        $key1 = new \stdClass();
        $key1->param = 'key1';
        $value1 = new \stdClass();
        $value1->param = 'value1';
        $this->dummyKeyType->isValid($key1)->willReturn(true);
        $this->dummyValueType->isValid($value1)->willReturn(true);
        $otherMap->put($key1, $value1);

        $key2 = new \stdClass();
        $key2->param = 'key2';
        $value2 = new \stdClass();
        $value2->param = 'value2';
        $this->dummyKeyType->isValid($key2)->willReturn(true);
        $this->dummyValueType->isValid($value2)->willReturn(true);
        $otherMap->put($key2, $value2);

        $key3 = new \stdClass();
        $key3->param = 'key3';
        $value3 = new \stdClass();
        $value3->param = 'value3';
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

        $key1 = new \stdClass();
        $key1->param = 'key1';
        $value1 = new \stdClass();
        $value1->param = 'value1';
        $this->dummyKeyType->isValid($key1)->willReturn(true);
        $this->dummyValueType->isValid($value1)->willReturn(true);
        $otherMap->put($key1, $value1);

        $key2 = new \stdClass();
        $key2->param = 'key2';
        $value2 = new \stdClass();
        $value2->param = 'value2';
        $this->dummyKeyType->isValid($key2)->willReturn(true);
        $this->dummyValueType->isValid($value2)->willReturn(true);
        $otherMap->put($key2, $value2);

        $key3 = new \stdClass();
        $key3->param = 'key3';
        $value3 = new \stdClass();
        $value3->param = 'value3';
        $this->dummyKeyType->isValid($key3)->willReturn(true);
        $this->dummyValueType->isValid($value3)->willReturn(true);
        $otherMap->put($key3, $value3);

        $this->map->putAll($otherMap);
        $result = $this->map->keys();

        $this->assertEquals([$key1, $key2, $key3], $result);
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

        $key1 = new \stdClass();
        $key1->param = 'key1';
        $value1 = new \stdClass();
        $value1->param = 'value1';
        $this->dummyKeyType->isValid($key1)->willReturn(true);
        $this->dummyValueType->isValid($value1)->willReturn(true);
        $otherMap->put($key1, $value1);

        $key2 = new \stdClass();
        $key2->param = 'key2';
        $value2 = new \stdClass();
        $value2->param = 'value2';
        $this->dummyKeyType->isValid($key2)->willReturn(true);
        $this->dummyValueType->isValid($value2)->willReturn(true);
        $otherMap->put($key2, $value2);

        $key3 = new \stdClass();
        $key3->param = 'key3';
        $value3 = new \stdClass();
        $value3->param = 'value3';
        $this->dummyKeyType->isValid($key3)->willReturn(true);
        $this->dummyValueType->isValid($value3)->willReturn(true);
        $otherMap->put($key3, $value3);

        $this->map->putAll($otherMap);
        $result = $this->map->values();

        $this->assertEquals([$value1, $value2, $value3], $result);
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

        $key1 = new \stdClass();
        $key1->param = 'base';
        $value1 = new \stdClass();
        $value1->param = 'new';
        $this->dummyKeyType->isValid($key1)->willReturn(true);
        $this->dummyValueType->isValid($value1)->willReturn(true);
        $otherMap->put($key1, $value1);

        $key2 = new \stdClass();
        $key2->param = 'key2';
        $value2 = new \stdClass();
        $value2->param = 'value2';
        $this->dummyKeyType->isValid($key2)->willReturn(true);
        $this->dummyValueType->isValid($value2)->willReturn(true);
        $otherMap->put($key2, $value2);

        $key3 = new \stdClass();
        $key3->param = 'key3';
        $value3 = new \stdClass();
        $value3->param = 'value3';
        $this->dummyKeyType->isValid($key3)->willReturn(true);
        $this->dummyValueType->isValid($value3)->willReturn(true);
        $otherMap->put($key3, $value3);

        $key0 = new \stdClass();
        $key0->param = 'key0';
        $value0 = new \stdClass();
        $value0->param = 'value0';
        $this->dummyKeyType->isValid($key0)->willReturn(true);
        $this->dummyValueType->isValid($value0)->willReturn(true);
        $this->map->put($key0, $value0);

        $key1 = new \stdClass();
        $key1->param = 'base';
        $value1 = new \stdClass();
        $value1->param = 'old';
        $this->dummyKeyType->isValid($key1)->willReturn(true);
        $this->dummyValueType->isValid($value1)->willReturn(true);
        $this->map->put($key1, $value1);

        $this->map->putAll($otherMap);
        $result = $this->map->keys();

        $this->assertEquals([$key0, $key1, $key2, $key3], $result);
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

        $key1 = new \stdClass();
        $key1->param = 'base';
        $valueNew = new \stdClass();
        $valueNew->param = 'new';
        $this->dummyKeyType->isValid($key1)->willReturn(true);
        $this->dummyValueType->isValid($valueNew)->willReturn(true);
        $otherMap->put($key1, $valueNew);

        $key2 = new \stdClass();
        $key2->param = 'key2';
        $value2 = new \stdClass();
        $value2->param = 'value2';
        $this->dummyKeyType->isValid($key2)->willReturn(true);
        $this->dummyValueType->isValid($value2)->willReturn(true);
        $otherMap->put($key2, $value2);

        $key3 = new \stdClass();
        $key3->param = 'key3';
        $value3 = new \stdClass();
        $value3->param = 'value3';
        $this->dummyKeyType->isValid($key3)->willReturn(true);
        $this->dummyValueType->isValid($value3)->willReturn(true);
        $otherMap->put($key3, $value3);

        $key0 = new \stdClass();
        $key0->param = 'key0';
        $value0 = new \stdClass();
        $value0->param = 'value0';
        $this->dummyKeyType->isValid($key0)->willReturn(true);
        $this->dummyValueType->isValid($value0)->willReturn(true);
        $this->map->put($key0, $value0);

        $key1 = new \stdClass();
        $key1->param = 'base';
        $value1 = new \stdClass();
        $value1->param = 'old';
        $this->dummyKeyType->isValid($key1)->willReturn(true);
        $this->dummyValueType->isValid($value1)->willReturn(true);
        $this->map->put($key1, $value1);

        $this->map->putAll($otherMap);
        $result = $this->map->values();

        $this->assertEquals([$value0, $valueNew, $value2, $value3], $result);
    }
}
