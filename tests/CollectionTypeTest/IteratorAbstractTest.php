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

namespace CollectionTypeTest;


use Fake\IteratorAbstractFake;

class IteratorAbstractTest extends \PHPUnit_Framework_TestCase
{
    /** @var \Fake\IteratorAbstractFake $iterator */
    private $iterator;

    public function setUp()
    {
        $this->iterator = new IteratorAbstractFake();
    }

    public function tearDown()
    {
        $this->iterator = null;
    }

    /**
     * @covers       CollectionType\IteratorAbstract::getIterator
     */
    public function testGetIterator()
    {
        $result = $this->iterator->getIterator();

        $this->assertInstanceOf('\ArrayIterator', $result);
    }

    /**
     * @covers       CollectionType\IteratorAbstract::count
     */
    public function testCountForNoneValues()
    {
        $result = $this->iterator->count();

        $this->assertEquals(0, $result);
    }

    /**
     * @covers       CollectionType\IteratorAbstract::count
     */
    public function testCountForManyValues()
    {
        $this->iterator->add('A');
        $this->iterator->add('B');
        $this->iterator->add('C');
        $this->iterator->add('D');
        $this->iterator->add('E');

        $result = $this->iterator->count();

        $this->assertEquals(5, $result);
    }

    /**
     * @covers       CollectionType\IteratorAbstract::clear
     */
    public function testClear()
    {
        $this->iterator->add('A');
        $this->iterator->add('B');

        $this->iterator->clear();

        $result = $this->iterator->count();

        $this->assertEquals(0, $result);
    }

    /**
     * @covers       CollectionType\IteratorAbstract::isEmpty
     */
    public function testIsEmptyForNoneValues()
    {
        $result = $this->iterator->isEmpty();

        $this->assertTrue($result);
    }

    /**
     * @covers       CollectionType\IteratorAbstract::isEmpty
     */
    public function testIsEmptyForFewValues()
    {
        $this->iterator->add('A');
        $this->iterator->add('B');

        $result = $this->iterator->isEmpty();

        $this->assertFalse($result);
    }

    /**
     * @covers       CollectionType\IteratorAbstract::current
     */
    public function testCurrentForNoneValues()
    {
        $result = $this->iterator->current();

        $this->assertFalse($result);
    }

    /**
     * @covers       CollectionType\IteratorAbstract::current
     */
    public function testCurrentForFewValues()
    {
        $this->iterator->add('A');
        $this->iterator->add('B');
        $this->iterator->add('C');

        $result = $this->iterator->current();

        $this->assertEquals('A', $result);
    }

    /**
     * @covers       CollectionType\IteratorAbstract::next
     */
    public function testNextForNoneValues()
    {
        $result = $this->iterator->next();

        $this->assertFalse($result);
    }

    /**
     * @covers       CollectionType\IteratorAbstract::next
     */
    public function testNextForFewValues()
    {
        $this->iterator->add('A');
        $this->iterator->add('B');
        $this->iterator->add('C');

        $result = $this->iterator->next();

        $this->assertEquals('B', $result);
    }

    /**
     * @covers       CollectionType\IteratorAbstract::key
     */
    public function testKeyForNoneValues()
    {
        $result = $this->iterator->key();

        $this->assertNull($result);
    }

    /**
     * @covers       CollectionType\IteratorAbstract::next
     */
    public function testKeyForFewValues()
    {
        $this->iterator->add('A');
        $this->iterator->add('B');
        $this->iterator->add('C');

        $result = $this->iterator->key();

        $this->assertEquals(0, $result);
    }

    /**
     * @covers       CollectionType\IteratorAbstract::next
     */
    public function testKeyForFewValuesAfterCallNextMethod()
    {
        $this->iterator->add('A');
        $this->iterator->add('B');
        $this->iterator->add('C');

        $this->iterator->next();
        $this->iterator->next();

        $result = $this->iterator->key();

        $this->assertEquals(2, $result);
    }

    /**
     * @covers       CollectionType\IteratorAbstract::first
     */
    public function testFirstForNoneValues()
    {
        $result = $this->iterator->first();

        $this->assertFalse($result);
    }

    /**
     * @covers       CollectionType\IteratorAbstract::first
     */
    public function testFirstForFewValues()
    {
        $this->iterator->add('A');
        $this->iterator->add('B');
        $this->iterator->add('C');

        $result = $this->iterator->first();

        $this->assertEquals('A', $result);
    }

    /**
     * @covers       CollectionType\IteratorAbstract::first
     */
    public function testFirstForFewValuesAfterCallNextMethod()
    {
        $this->iterator->add('A');
        $this->iterator->add('B');
        $this->iterator->add('C');

        $this->iterator->next();
        $this->iterator->next();

        $result = $this->iterator->first();

        $this->assertEquals('A', $result);
    }

    /**
     * @covers       CollectionType\IteratorAbstract::last
     */
    public function testLastForNoneValues()
    {
        $result = $this->iterator->last();

        $this->assertFalse($result);
    }

    /**
     * @covers       CollectionType\IteratorAbstract::last
     */
    public function testLastForFewValues()
    {
        $this->iterator->add('A');
        $this->iterator->add('B');
        $this->iterator->add('C');

        $result = $this->iterator->last();

        $this->assertEquals('C', $result);
    }

    /**
     * @covers       CollectionType\IteratorAbstract::rewind
     */
    public function testRewindForNoneValues()
    {
        $result = $this->iterator->rewind();

        $this->assertFalse($result);
    }

    /**
     * @covers       CollectionType\IteratorAbstract::rewind
     */
    public function testRewindForFewValues()
    {
        $this->iterator->add('A');
        $this->iterator->add('B');
        $this->iterator->add('C');

        $result = $this->iterator->rewind();

        $this->assertEquals('A', $result);
    }

    /**
     * @covers       CollectionType\IteratorAbstract::rewind
     */
    public function testRewindForFewValuesAfterCallNextMethod()
    {
        $this->iterator->add('A');
        $this->iterator->add('B');
        $this->iterator->add('C');

        $this->iterator->next();
        $this->iterator->next();

        $result = $this->iterator->rewind();

        $this->assertEquals('A', $result);
    }
}