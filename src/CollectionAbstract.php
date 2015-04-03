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

abstract class CollectionAbstract extends IteratorAbstract implements CollectionInterface
{
    use CollectionTypeUtilTrait;
    use ValueTypeTrait;

    public function __construct(TypeInterface $type)
    {
        $this->setValueType($type);
    }

    public function getAll()
    {
        return $this->values;
    }

    public function removeAll(CollectionInterface $collection)
    {
        if (!$this->containsAll($collection)) {
            return false;
        }

        foreach ($collection as $value) {
            $this->remove($value);
        }

        return true;
    }

    public function containsAll(CollectionInterface $collection)
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

        $diff = $this->twoArraysDiff($collection->toArray(), $this->values);

        return empty($diff);
    }

    public function equalType(TypeInterface $type)
    {
        return ($this->getType() === $type);
    }

    public function getType()
    {
        return $this->getValueType();
    }

    public function remove($value)
    {
        if (!$this->getType()->isValid($value)) {
            throw new InvalidTypeException(sprintf('The value is incorrect type. %s given!', gettype($value)));
        }

        if (!$this->contains($value)) {
            return false;
        }

        $key = array_search($value, $this->values);

        array_splice($this->values, $key, 1);

        return true;
    }

    public function contains($value)
    {
        if (!$this->getType()->isValid($value)) {
            throw new InvalidTypeException(sprintf('The value is incorrect type. %s given!', gettype($value)));
        }

        return in_array($value, $this->values, true);
    }

    public function clear()
    {
        $this->values = [];
    }

    public function equals(CollectionInterface $collection)
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

        if ($this->count() != $collection->count()) {
            return false;
        }

        return empty($this->twoArraysDiff($this->toArray(), $collection->toArray()));
    }

    public function toArray()
    {
        return (array)$this->values;
    }
}
