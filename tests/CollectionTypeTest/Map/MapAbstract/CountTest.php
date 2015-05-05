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

class CountTest extends \PHPUnit_Framework_TestCase
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
     * @covers       CollectionType\Map\MapAbstract::count
     * @covers       CollectionType\Map\MapAbstract::__construct
     * @covers       CollectionType\Map\MapAbstract::isSynchronizedIndex
     */
    public function testCountForEmptyMap()
    {
        $this->map->clear();

        $result = $this->map->count();

        $this->assertEquals(0, $result);
    }

    /**
     * @covers       CollectionType\Map\MapAbstract::count
     * @covers       CollectionType\Map\MapAbstract::__construct
     * @covers       CollectionType\Map\MapAbstract::isSynchronizedIndex
     */
    public function testCountForFilledMap()
    {
        $key1 = '1';
        $value1 = '1';
        $this->dummyKeyType->isValid($key1)->willReturn(true);
        $this->dummyValueType->isValid($value1)->willReturn(true);
        $this->map->put($key1, $value1);

        $key2 = '2';
        $value2 = '2';
        $this->dummyKeyType->isValid($key2)->willReturn(true);
        $this->dummyValueType->isValid($value2)->willReturn(true);
        $this->map->put($key2, $value2);

        $result = $this->map->count();

        $this->assertEquals(2, $result);
    }

    /**
     * @expectedException \CollectionType\Exception\SynchronizeException
     *
     * @covers       CollectionType\Map\MapAbstract::count
     * @covers       CollectionType\Map\MapAbstract::__construct
     * @covers       CollectionType\Map\MapAbstract::isSynchronizedIndex
     */
    public function testCountForNotSynchronizedMap()
    {
        $this->map->putKey(1);

        $this->map->count();
    }
}
