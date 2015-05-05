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

namespace CollectionTypeTest\Collection\CollectionList\ListAbstract;

use Fake\Collection\CollectionList\ListAbstractFake;

class AddTest extends \PHPUnit_Framework_TestCase
{
    /** @var \Fake\Collection\CollectionList\ListAbstractFake $list */
    private $list;

    private $dummyType;

    public function setUp()
    {
        $this->dummyType = $this->prophesize('CollectionType\TypeValidator\StringTypeValidator');
        $this->dummyType->willImplement('CollectionType\TypeValidator\TypeValidatorInterface');

        $this->list = new ListAbstractFake($this->dummyType->reveal());
    }

    public function tearDown()
    {
        $this->list = null;
        $this->dummyType = null;
    }

    /**
     * @expectedException \CollectionType\Exception\InvalidTypeException
     *
     * @covers       CollectionType\Collection\CollectionList\ListAbstract::add
     * @covers       CollectionType\Collection\CollectionList\ListAbstract::__construct
     */
    public function testAddForIncorrectValueThrowException()
    {
        $value = 1;
        $this->dummyType->isValid($value)->willReturn(false);

        $this->list->add($value);
    }

    /**
     * @covers       CollectionType\Collection\CollectionList\ListAbstract::add
     * @covers       CollectionType\Collection\CollectionList\ListAbstract::__construct
     */
    public function testAddToEmpty()
    {
        $value = 'value';
        $this->dummyType->isValid($value)->willReturn(true);

        $result = $this->list->add($value);

        $this->assertTrue($result);
    }

    /**
     * @covers       CollectionType\Collection\CollectionList\ListAbstract::add
     * @covers       CollectionType\Collection\CollectionList\ListAbstract::__construct
     */
    public function testAddFewValues()
    {
        $value1 = '1';
        $this->dummyType->isValid($value1)->willReturn(true);

        $value2 = '2';
        $this->dummyType->isValid($value2)->willReturn(true);

        $value3 = '3';
        $this->dummyType->isValid($value3)->willReturn(true);

        $this->list->add($value2);
        $this->list->add($value3);
        $this->list->add($value1);

        $result = $this->list->getAll();
        $this->assertEquals([$value2, $value3, $value1], $result);
    }

    /**
     * @covers       CollectionType\Collection\CollectionList\ListAbstract::add
     * @covers       CollectionType\Collection\CollectionList\ListAbstract::__construct
     */
    public function testAddTheSameValues()
    {
        $value1 = '1';
        $this->dummyType->isValid($value1)->willReturn(true);

        $value2 = '2';
        $this->dummyType->isValid($value2)->willReturn(true);

        $this->list->add($value1);
        $this->list->add($value2);
        $this->list->add($value1);
        $this->list->add($value1);

        $result = $this->list->getAll();
        $this->assertEquals([$value1, $value2, $value1, $value1], $result);
    }
}