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

namespace CollectionTypeTest\Collection\CollectionAbstract;

use Fake\Collection\CollectionAbstractFake;
use PHPUnit_Framework_TestCase;

class ConstructorTest extends PHPUnit_Framework_TestCase
{

    /**
     * @expectedException \PHPUnit_Framework_Error
     *
     * @covers CollectionType\Collection\CollectionAbstract::__construct
     * @covers CollectionType\Common\ValueTypeTrait::setValueType
     */
    public function testConstructorWithNullParameter()
    {
        new CollectionAbstractFake(null);
    }

    /**
     * @covers       CollectionType\Collection\CollectionAbstract::__construct
     * @covers       CollectionType\Common\ValueTypeTrait::setValueType
     *
     * @dataProvider correctTypesDataProvider
     *
     * @param string $type - class name of type
     */
    public function testConstructorSetForCorrectType($type)
    {
        $dummyType = $this->prophesize($type)
            ->willImplement('CollectionType\TypeValidator\TypeValidatorInterface')
            ->reveal();

        $collectionAbstract = new CollectionAbstractFake($dummyType);

        $this->assertInstanceOf('Fake\Collection\CollectionAbstractFake', $collectionAbstract);
    }

    public function correctTypesDataProvider()
    {
        return [
            ['CollectionType\TypeValidator\ArrayTypeValidator'],
            ['CollectionType\TypeValidator\FloatTypeValidator'],
            ['CollectionType\TypeValidator\IntegerTypeValidator'],
            ['CollectionType\TypeValidator\NullTypeValidator'],
            ['CollectionType\TypeValidator\ObjectTypeValidator'],
            ['CollectionType\TypeValidator\StringTypeValidator'],
        ];
    }
}