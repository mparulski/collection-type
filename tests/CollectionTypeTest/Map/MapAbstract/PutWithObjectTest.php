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

class PutWithObjectTest extends \PHPUnit_Framework_TestCase
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
     * @covers       CollectionType\Map\MapAbstract::put
     * @covers       CollectionType\Map\MapAbstract::isSynchronizedKeyAndValue
     * @covers       CollectionType\Map\MapAbstract::__construct
     * @covers       CollectionType\Common\KeyTypeTrait::validateValueForKeyType
     * @covers       CollectionType\Common\ValueTypeTrait::validateValueForValueType
     */
    public function testPutForCorrectKeyTypeAndCorrectValueType()
    {
        $key = new \stdClass();
        $key->param = 'key';
        $value = new \stdClass();
        $value->param = 'value';

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
        $key = new \stdClass();
        $key->param = 'key';
        $oldValue = new \stdClass();
        $oldValue->param = 'oldValue';

        $this->dummyKeyType->isValid($key)->willReturn(true);
        $this->dummyValueType->isValid($oldValue)->willReturn(true);

        $this->map->put($key, $oldValue);

        $newValue = new \stdClass();
        $newValue->param = 'newValue';
        $this->dummyValueType->isValid($newValue)->willReturn(true);

        $this->map->put($key, $newValue);
        $result = $this->map->get($key);

        $this->assertEquals($newValue, $result);
    }
}
