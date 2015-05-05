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

class ContainsAllWithObjectTest extends \PHPUnit_Framework_TestCase
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
     * @covers       CollectionType\Map\MapAbstract::containsAll
     * @covers       CollectionType\Map\MapAbstract::__construct
     * @covers       CollectionType\Common\KeyTypeTrait::validateKeyType
     * @covers       CollectionType\Common\ValueTypeTrait::validateValueType
     * @covers       CollectionType\Common\Util\UtilTrait::diffArrays
     */
    public function testContainsAllInEmptyMap()
    {
        $otherMap = new MapAbstractFake($this->dummyKeyType->reveal(), $this->dummyValueType->reveal());

        $key1 = new \stdClass();
        $key1->param = 'key';
        $value1 = new \stdClass();
        $value1->param = 'value';
        $this->dummyKeyType->isValid($key1)->willReturn(true);
        $this->dummyValueType->isValid($value1)->willReturn(true);
        $otherMap->put($key1, $value1);

        $key2 = new \stdClass();
        $key2->param = 'key';
        $value2 = new \stdClass();
        $value2->param = 'value';
        $this->dummyKeyType->isValid($key2)->willReturn(true);
        $this->dummyValueType->isValid($value2)->willReturn(true);
        $otherMap->put($key2, $value2);

        $key3 = new \stdClass();
        $key3->param = 'key';
        $value3 = new \stdClass();
        $value3->param = 'value';
        $this->dummyKeyType->isValid($key3)->willReturn(true);
        $this->dummyValueType->isValid($value3)->willReturn(true);
        $otherMap->put($key3, $value3);

        $result = $this->map->containsAll($otherMap);

        $this->assertFalse($result);
    }

    /**
     * @covers       CollectionType\Map\MapAbstract::containsAll
     * @covers       CollectionType\Map\MapAbstract::__construct
     * @covers       CollectionType\Common\KeyTypeTrait::validateKeyType
     * @covers       CollectionType\Common\ValueTypeTrait::validateValueType
     * @covers       CollectionType\Common\Util\UtilTrait::diffArrays
     */
    public function testContainsAllWhenMapContainsSomeElements()
    {
        $otherMap = new MapAbstractFake($this->dummyKeyType->reveal(), $this->dummyValueType->reveal());

        $key1 = new \stdClass();
        $key1->param = 'key';
        $value1 = new \stdClass();
        $value1->param = 'value';
        $this->dummyKeyType->isValid($key1)->willReturn(true);
        $this->dummyValueType->isValid($value1)->willReturn(true);
        $this->map->put($key1, $value1);
        $otherMap->put($key1, $value1);

        $key2 = new \stdClass();
        $key2->param = 'key';
        $value2 = new \stdClass();
        $value2->param = 'value';
        $this->dummyKeyType->isValid($key2)->willReturn(true);
        $this->dummyValueType->isValid($value2)->willReturn(true);
        $this->map->put($key2, $value2);
        $otherMap->put($key2, $value2);

        $key3 = new \stdClass();
        $key3->param = 'key';
        $value3 = new \stdClass();
        $value3->param = 'value';
        $this->dummyKeyType->isValid($key3)->willReturn(true);
        $this->dummyValueType->isValid($value3)->willReturn(true);
        $otherMap->put($key3, $value3);

        $result = $this->map->containsAll($otherMap);

        $this->assertFalse($result);
    }

    /**
     * @covers       CollectionType\Map\MapAbstract::containsAll
     * @covers       CollectionType\Map\MapAbstract::__construct
     * @covers       CollectionType\Common\KeyTypeTrait::validateKeyType
     * @covers       CollectionType\Common\ValueTypeTrait::validateValueType
     * @covers       CollectionType\Common\Util\UtilTrait::diffArrays
     */
    public function testContainsAllWhenMapContainsAllElements()
    {
        $otherMap = new MapAbstractFake($this->dummyKeyType->reveal(), $this->dummyValueType->reveal());

        $key1 = new \stdClass();
        $key1->param = 'key';
        $value1 = new \stdClass();
        $value1->param = 'value';
        $this->dummyKeyType->isValid($key1)->willReturn(true);
        $this->dummyValueType->isValid($value1)->willReturn(true);
        $this->map->put($key1, $value1);
        $otherMap->put($key1, $value1);

        $key2 = new \stdClass();
        $key2->param = 'key';
        $value2 = new \stdClass();
        $value2->param = 'value';
        $this->dummyKeyType->isValid($key2)->willReturn(true);
        $this->dummyValueType->isValid($value2)->willReturn(true);
        $this->map->put($key2, $value2);
        $otherMap->put($key2, $value2);

        $key3 = new \stdClass();
        $key3->param = 'key';
        $value3 = new \stdClass();
        $value3->param = 'value';
        $this->dummyKeyType->isValid($key3)->willReturn(true);
        $this->dummyValueType->isValid($value3)->willReturn(true);
        $this->map->put($key3, $value3);
        $otherMap->put($key3, $value3);

        $result = $this->map->containsAll($otherMap);

        $this->assertTrue($result);
    }
}
