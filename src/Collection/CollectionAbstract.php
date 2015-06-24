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

namespace CollectionType\Collection;

use CollectionType\Common\Util\UtilTrait;
use CollectionType\Common\ValueTypeTrait;
use CollectionType\Iterator\IteratorAbstract;
use CollectionType\TypeValidator\TypeValidatorInterface;

abstract class CollectionAbstract extends IteratorAbstract implements CollectionInterface
{
    use UtilTrait;
    use ValueTypeTrait;

    public function __construct(TypeValidatorInterface $valueType)
    {
        $this->setValueType($valueType);
    }

    public function clear()
    {
        $this->values = [];
    }

    public function equalType(TypeValidatorInterface $type)
    {
        return $this->equalValueType($type);
    }

    public function equals(CollectionInterface $collection)
    {
        $this->validateValueType($collection->getValueType());

        if ($this->count() != $collection->count()) {
            return false;
        }

        return $this->equalArrays($this->toArray(), $collection->toArray());
    }

    public function getAll()
    {
        return $this->values;
    }

    public function toArray()
    {
        return (array)$this->values;
    }

    abstract public function add($value);

    public function remove($value)
    {
        if (!$this->contains($value)) {
            return false;
        }

        $key = array_search($value, $this->values);

        array_splice($this->values, $key, 1);

        return true;
    }

    public function removeAll(CollectionInterface $collection)
    {
        if (!$this->containsAll($collection)) {
            return false;
        }

        $collectionIterator = new \ArrayIterator($collection->toArray());
        foreach (new \IteratorIterator($collectionIterator) as $value) {
            $this->remove($value);
        }

        return true;
    }

    public function removeAny(CollectionInterface $collection)
    {
        $this->validateValueType($collection->getValueType());

        $collectionIterator = new \ArrayIterator($collection->toArray());
        foreach (new \IteratorIterator($collectionIterator) as $value) {
            $this->remove($value);
        }

        return true;
    }

    public function contains($value)
    {
        $this->validateValueForValueType($value);

        return in_array($value, $this->values, true);
    }

    public function containsAll(CollectionInterface $collection)
    {
        $this->validateValueType($collection->getValueType());

        return $this->equalArrays($collection->toArray(), $this->values);
    }

    public function getDifference(CollectionInterface $collection)
    {
        $this->validateValueType($collection->getValueType());

        $diffCollection = clone $this;
        $diffCollection->removeAny($collection);

        return $diffCollection;
    }
}
