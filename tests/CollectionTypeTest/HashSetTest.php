<?php
/**
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SH THE COPYRIGHT
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


use CollectionType\HashSet;

class HashSetTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @expectedException \CollectionType\Exception\InvalidTypeException
     *
     * @covers       CollectionType\HashSet::add
     * @covers       CollectionType\HashSet::__construct
     * @covers       CollectionType\SetAbstract::__construct
     */
    public function testAddForWrongTypeCollectionThrowException()
    {
        $type = $this->prophesize('CollectionType\Type\StringType');
        $type->willImplement('CollectionType\Type\TypeInterface');

        $set = new HashSet($type->reveal());

        $value = 1;
        $type->isValid($value)->willReturn(false);
        $set->add($value);
    }

    /**
     * @covers       CollectionType\HashSet::add
     * @covers       CollectionType\HashSet::__construct
     * @covers       CollectionType\SetAbstract::__construct
     */
    public function testAddForUnrepeatableValues()
    {
        $type = $this->prophesize('CollectionType\Type\StringType');
        $type->willImplement('CollectionType\Type\TypeInterface');

        $set = new HashSet($type->reveal());

        $value = 'A';
        $type->isValid($value)->willReturn(true);
        $resultA = $set->add($value);

        $value = 'B';
        $type->isValid($value)->willReturn(true);
        $resultB = $set->add($value);

        $value = 'C';
        $type->isValid($value)->willReturn(true);
        $resultC = $set->add($value);

        $this->assertTrue($resultA && $resultB && $resultC);
    }

    /**
     * @covers       CollectionType\HashSet::add
     * @covers       CollectionType\HashSet::__construct
     * @covers       CollectionType\SetAbstract::__construct
     */
    public function testAddForRepeatableValues()
    {
        $type = $this->prophesize('CollectionType\Type\StringType');
        $type->willImplement('CollectionType\Type\TypeInterface');

        $set = new HashSet($type->reveal());

        $value = 'A';
        $type->isValid($value)->willReturn(true);
        $set->add($value);

        $value = 'A';
        $type->isValid($value)->willReturn(true);
        $result = $set->add($value);

        $this->assertFalse($result);
    }
}