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

namespace CollectionTypeTest\Iterator\IteratorAbstract;

use Fake\Iterator\IteratorAbstractFake;

class IsEmptyTest extends \PHPUnit_Framework_TestCase
{
    /** @var \Fake\Iterator\IteratorAbstractFake $iterator */
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
     * @covers       CollectionType\Iterator\IteratorAbstract::isEmpty
     */
    public function testIsEmptyForNoneValues()
    {
        $result = $this->iterator->isEmpty();

        $this->assertTrue($result);
    }

    /**
     * @covers       CollectionType\Iterator\IteratorAbstract::isEmpty
     */
    public function testIsEmptyForFewValues()
    {
        $this->iterator->add('A');
        $this->iterator->add('B');

        $result = $this->iterator->isEmpty();

        $this->assertFalse($result);
    }
}