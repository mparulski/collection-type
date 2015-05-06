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

namespace CollectionType\Collection\CollectionList;

use CollectionType\Collection\CollectionAbstract;
use CollectionType\Exception\InvalidTypeException;
use CollectionType\TypeValidator\TypeValidatorInterface;

abstract class ListAbstract extends CollectionAbstract implements ListInterface
{
    public function __construct(TypeValidatorInterface $valueType)
    {
        parent::__construct($valueType);
    }

    public function add($value)
    {
        if (!$this->getValueType()->isValid($value)) {
            throw new InvalidTypeException(sprintf('The value is incorrect type. %s given!', gettype($value)));
        }

        $this->values[] = $value;

        return true;
    }

    public function addAll(ListInterface $collection)
    {
        if (!$this->equalType($collection->getValueType())) {
            throw new InvalidTypeException(
                sprintf(
                    'The collection is incorrect type. %s given. Must be: %s type!',
                    get_class($collection->getValueType()),
                    get_class($this->getValueType())
                )
            );
        }

        $this->values = array_merge($this->values, $collection->toArray());

        return true;
    }
}
