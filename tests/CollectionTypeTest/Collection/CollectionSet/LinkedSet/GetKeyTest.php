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

namespace CollectionTypeTest\Collection\CollectionSet\LinkedSet;

use CollectionType\Collection\CollectionSet\LinkedSet;

class GetKeyTest extends \PHPUnit_Framework_TestCase
{
    /** @var \CollectionType\Collection\CollectionSet\LinkedSet $set */
    private $set;

    private $dummyType;

    public function setUp()
    {
        $this->dummyType = $this->prophesize('CollectionType\TypeValidator\StringTypeValidator');
        $this->dummyType->willImplement('CollectionType\TypeValidator\TypeValidatorInterface');

        $this->set = new LinkedSet($this->dummyType->reveal());
    }

    public function tearDown()
    {
        $this->set = null;
        $this->dummyType = null;
    }

    /**
     * @covers       CollectionType\Collection\CollectionSet\LinkedSet::getKey
     * @covers       CollectionType\Collection\CollectionSet\LinkedSet::__construct
     * @covers       CollectionType\Common\ValueTypeTrait::validateValueForValueType
     */
    public function testGetKeyForNonExistsValue()
    {
        $value = '0';
        $this->dummyType->isValid($value)->willReturn(true);
        $this->set->add($value);

        $searchingValue = 100;
        $this->dummyType->isValid($searchingValue)->willReturn(true);

        $result = $this->set->getKey($searchingValue);

        $this->assertFalse($result);
    }

    /**
     * @covers       CollectionType\Collection\CollectionSet\LinkedSet::getKey
     * @covers       CollectionType\Collection\CollectionSet\LinkedSet::__construct
     * @covers       CollectionType\Common\ValueTypeTrait::validateValueForValueType
     */
    public function testGetKeyForExistsValue()
    {
        $value = '0';
        $this->dummyType->isValid($value)->willReturn(true);
        $this->set->add($value);

        $result = $this->set->getKey($value);

        $this->assertEquals(0, $result);
    }
}