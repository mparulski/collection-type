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

class EqualsTest extends \PHPUnit_Framework_TestCase
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
     * @covers       CollectionType\Map\MapAbstract::equals
     * @covers       CollectionType\Map\MapAbstract::__construct
     * @covers       CollectionType\Common\KeyTypeTrait::validateKeyType
     * @covers       CollectionType\Common\ValueTypeTrait::validateValueType
     */
    public function testEqualsForTheSameInstance()
    {
        $result = $this->map->equals($this->map);

        $this->assertTrue($result);
    }

    /**
     * @expectedException \CollectionType\Exception\InvalidTypeException
     *
     * @covers       CollectionType\Map\MapAbstract::equals
     * @covers       CollectionType\Map\MapAbstract::__construct
     * @covers       CollectionType\Common\KeyTypeTrait::validateKeyType
     * @covers       CollectionType\Common\ValueTypeTrait::validateValueType
     */
    public function testEqualsForTheSameMapTypes()
    {
        $dummyKeyType = $this->prophesize('CollectionType\TypeValidator\IntegerTypeValidator');
        $dummyKeyType->willImplement('CollectionType\TypeValidator\TypeValidatorInterface');

        $dummyValueType = $this->prophesize('CollectionType\TypeValidator\StringTypeValidator');
        $dummyValueType->willImplement('CollectionType\TypeValidator\TypeValidatorInterface');

        $anotherMap = new MapAbstractFake($dummyKeyType->reveal(), $dummyValueType->reveal());

        $result = $this->map->equals($anotherMap);

        $this->assertTrue($result);
    }

    /**
     * @expectedException \CollectionType\Exception\InvalidTypeException
     *
     * @covers       CollectionType\Map\MapAbstract::equals
     * @covers       CollectionType\Map\MapAbstract::__construct
     * @covers       CollectionType\Common\KeyTypeTrait::validateKeyType
     * @covers       CollectionType\Common\ValueTypeTrait::validateValueType
     */
    public function testEqualsForTheDifferentValueType()
    {
        $dummyKeyType = $this->prophesize('CollectionType\TypeValidator\StringTypeValidator');
        $dummyKeyType->willImplement('CollectionType\TypeValidator\TypeValidatorInterface');

        $dummyValueType = $this->prophesize('CollectionType\TypeValidator\IntegerTypeValidator');
        $dummyValueType->willImplement('CollectionType\TypeValidator\TypeValidatorInterface');

        $anotherMap = new MapAbstractFake($dummyKeyType->reveal(), $dummyValueType->reveal());

        $result = $this->map->equals($anotherMap);

        $this->assertTrue($result);
    }
}