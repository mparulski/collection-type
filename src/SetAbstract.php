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

namespace CollectionType;

use CollectionType\Exception\InvalidTypeException;
use CollectionType\Type\TypeInterface;

abstract class SetAbstract extends CollectionAbstract implements SetInterface
{
    use CollectionTypeUtilTrait;

    public function __construct(TypeInterface $type)
    {
        parent::__construct($type);
    }

    public function addAll(SetInterface $collection)
    {
        if (!$this->equalType($collection->getType())) {
            throw new InvalidTypeException(
                sprintf(
                    'The collection is incorrect type. %s given. Must be: %s type!',
                    get_class($collection->getType()),
                    get_class($this->getType())
                )
            );
        }

        $uniqueValues = $this->twoArraysDiff($collection->toArray(), $this->values);

        $this->values = array_merge($this->values, $uniqueValues);

        return true;
    }
}
