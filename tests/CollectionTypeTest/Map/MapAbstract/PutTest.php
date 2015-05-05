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

class PutTest extends \PHPUnit_Framework_TestCase
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
     * @covers       CollectionType\Map\MapAbstract::put
     * @covers       CollectionType\Map\MapAbstract::isSynchronizedKeyAndValue
     * @covers       CollectionType\Map\MapAbstract::__construct
     * @covers       CollectionType\Common\ValueTypeTrait::validateValueForValueType
     */
    public function testPutForIncorrectKeyTypeAndCorrectValueType()
    {
        $key = 1;
        $value = 'string';

        $this->dummyKeyType->isValid($key)->willReturn(false);
        $this->dummyValueType->isValid($value)->willReturn(true);

        $this->map->put($key, $value);
    }

    /**
     * @expectedException \CollectionType\Exception\InvalidTypeException
     *
     * @covers       CollectionType\Map\MapAbstract::put
     * @covers       CollectionType\Map\MapAbstract::isSynchronizedKeyAndValue
     * @covers       CollectionType\Map\MapAbstract::__construct
     * @covers       CollectionType\Common\KeyTypeTrait::validateValueForKeyType
     * @covers       CollectionType\Common\ValueTypeTrait::validateValueForValueType
     */
    public function testPutForCorrectKeyTypeAndIncorrectValueType()
    {
        $key = 'string';
        $value = 1;

        $this->dummyKeyType->isValid($key)->willReturn(true);
        $this->dummyValueType->isValid($value)->willReturn(false);

        $this->map->put($key, $value);
    }

    /**
     * @expectedException \CollectionType\Exception\InvalidTypeException
     *
     * @covers       CollectionType\Map\MapAbstract::put
     * @covers       CollectionType\Map\MapAbstract::isSynchronizedKeyAndValue
     * @covers       CollectionType\Map\MapAbstract::__construct
     * @covers       CollectionType\Common\KeyTypeTrait::validateValueForKeyType
     * @covers       CollectionType\Common\ValueTypeTrait::validateValueForValueType
     */
    public function testPutForIncorrectKeyTypeAndIncorrectValueType()
    {
        $key = 1;
        $value = 1;

        $this->dummyKeyType->isValid($key)->willReturn(false);
        $this->dummyValueType->isValid($value)->willReturn(false);

        $this->map->put($key, $value);
    }

    /**
     * @covers       CollectionType\Map\MapAbstract::put
     * @covers       CollectionType\Map\MapAbstract::isSynchronizedKeyAndValue
     * @covers       CollectionType\Map\MapAbstract::__construct
     * @covers       CollectionType\Common\KeyTypeTrait::validateValueForKeyType
     * @covers       CollectionType\Common\ValueTypeTrait::validateValueForValueType
     */
    public function testPutForCorrectKeyTypeAndCorrectValueType()
    {
        $key = 'string';
        $value = 'string';

        $this->dummyKeyType->isValid($key)->willReturn(true);
        $this->dummyValueType->isValid($value)->willReturn(true);

        $result = $this->map->put($key, $value);

        $this->assertTrue($result);
    }

    /**
     * @covers       CollectionType\Map\MapAbstract::put
     * @covers       CollectionType\Map\MapAbstract::isSynchronizedKeyAndValue
     * @covers       CollectionType\Map\MapAbstract::__construct
     * @covers       CollectionType\Common\KeyTypeTrait::validateValueForKeyType
     * @covers       CollectionType\Common\ValueTypeTrait::validateValueForValueType
     */
    public function testPutForOverrideValue()
    {
        $key = 'key';
        $valueOld = 'old';
        $this->dummyKeyType->isValid($key)->willReturn(true);
        $this->dummyValueType->isValid($valueOld)->willReturn(true);

        $this->map->put($key, $valueOld);

        $valueNew = 'new';
        $this->dummyValueType->isValid($valueNew)->willReturn(true);

        $this->map->put($key, $valueNew);
        $result = $this->map->get($key);

        $this->assertEquals($valueNew, $result);
    }

    /**
     * @expectedException \CollectionType\Exception\SynchronizeException
     *
     * @covers       CollectionType\Map\MapAbstract::put
     * @covers       CollectionType\Map\MapAbstract::isSynchronizedKeyAndValue
     * @covers       CollectionType\Map\MapAbstract::__construct
     * @covers       CollectionType\Common\KeyTypeTrait::validateValueForKeyType
     * @covers       CollectionType\Common\ValueTypeTrait::validateValueForValueType
     */
    public function testNotSynchronizedMapForKey()
    {
        $this->map->putKey('1');

        $key = '2';
        $value = '2';
        $this->dummyKeyType->isValid($key)->willReturn(true);
        $this->dummyValueType->isValid($value)->willReturn(true);

        $this->map->put($key, $value);
    }

    /**
     * @expectedException \CollectionType\Exception\SynchronizeException
     *
     * @covers       CollectionType\Map\MapAbstract::put
     * @covers       CollectionType\Map\MapAbstract::isSynchronizedKeyAndValue
     * @covers       CollectionType\Map\MapAbstract::__construct
     * @covers       CollectionType\Common\KeyTypeTrait::validateValueForKeyType
     * @covers       CollectionType\Common\ValueTypeTrait::validateValueForValueType
     */
    public function testNotSynchronizedMapForValue()
    {
        $this->map->putValue('1');

        $key = '2';
        $value = '2';
        $this->dummyKeyType->isValid($key)->willReturn(true);
        $this->dummyValueType->isValid($value)->willReturn(true);

        $this->map->put($key, $value);
    }
}
