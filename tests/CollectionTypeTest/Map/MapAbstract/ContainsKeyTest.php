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

class ContainsKeysTest extends \PHPUnit_Framework_TestCase
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
     * @covers       CollectionType\Map\MapAbstract::containsKey
     * @covers       CollectionType\Map\MapAbstract::put
     * @covers       CollectionType\Map\MapAbstract::__construct
     * @covers       CollectionType\Common\KeyTypeTrait::validateValueForKeyType
     */
    public function testContainsKeyForCorrectKeyTypeAndAvailableKey()
    {
        $key = 'key';
        $value = 'value';

        $this->dummyKeyType->isValid($key)->willReturn(true);
        $this->dummyValueType->isValid($value)->willReturn(true);

        $this->map->put($key, $value);

        $result = $this->map->containsKey($key);

        $this->assertTrue($result);
    }

    /**
     * @covers       CollectionType\Map\MapAbstract::containsKey
     * @covers       CollectionType\Map\MapAbstract::put
     * @covers       CollectionType\Map\MapAbstract::__construct
     * @covers       CollectionType\Common\KeyTypeTrait::validateValueForKeyType
     */
    public function testContainsKeyForCorrectKeyTypeAndNotAvailableKey()
    {
        $key = 'key';
        $value = 'value';

        $this->dummyKeyType->isValid($key)->willReturn(true);
        $this->dummyValueType->isValid($value)->willReturn(true);

        $this->map->put($key, $value);

        $notExists = 'notExists';
        $this->dummyKeyType->isValid($notExists)->willReturn(true);
        $result = $this->map->containsKey($notExists);

        $this->assertFalse($result);
    }

    /**
     * @expectedException \CollectionType\Exception\InvalidTypeException
     *
     * @covers       CollectionType\Map\MapAbstract::containsKey
     * @covers       CollectionType\Map\MapAbstract::put
     * @covers       CollectionType\Map\MapAbstract::__construct
     * @covers       CollectionType\Common\KeyTypeTrait::validateValueForKeyType
     */
    public function testContainsKeyForIncorrectKeyType()
    {
        $key = 'key';
        $value = 'value';

        $this->dummyKeyType->isValid($key)->willReturn(true);
        $this->dummyValueType->isValid($value)->willReturn(true);

        $this->map->put($key, $value);

        $incorrect = 1;
        $this->dummyKeyType->isValid($incorrect)->willReturn(false);

        $this->map->containsKey($incorrect);
    }
}