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
namespace CollectionType\Map;

use CollectionType\Common\KeyTypeTrait;
use CollectionType\Common\Util\UtilTrait;
use CollectionType\Common\ValueTypeTrait;
use CollectionType\Exception\IndexException;
use CollectionType\Exception\InvalidTypeException;
use CollectionType\Exception\SynchronizeException;
use CollectionType\TypeValidator\TypeValidatorInterface;

abstract class MapAbstract implements MapInterface
{
    use KeyTypeTrait;
    use ValueTypeTrait;
    use UtilTrait;

    protected $keys = [];

    protected $values = [];

    public function __construct(TypeValidatorInterface $keyType, TypeValidatorInterface $valueType)
    {
        $this->setKeyType($keyType);
        $this->setValueType($valueType);
    }

    public function count()
    {
        if (!$this->isSynchronizedIndex()) {
            throw new SynchronizeException('Error occurred under synchronize pair: key and value lists!');
        }

        return count($this->keys);
    }

    public function clear()
    {
        $this->keys = [];
        $this->values = [];
    }

    public function isEmpty()
    {
        if (!$this->isSynchronizedIndex()) {
            throw new SynchronizeException('Error occurred under synchronize pair: key and value lists!');
        }

        return empty($this->keys);
    }

    public function equalType(TypeValidatorInterface $keyType, TypeValidatorInterface $valueType)
    {
        return ($this->equalKeyType($keyType) && $this->equalValueType($valueType));
    }

    public function equals(MapInterface $map)
    {
        $this->validateKeyType($map->getKeyType());
        $this->validateValueType($map->getValueType());

        return $this == $map;
    }

    public function get($key)
    {
        $this->validateValueForKeyType($key);

        if (!in_array($key, $this->keys)) {
            throw new IndexException('Key in Map does not exists!');
        }

        $index = array_search($key, $this->keys);

        return $this->values[$index];
    }

    public function getKeyOfValue($value)
    {
        $this->validateValueForValueType($value);

        if (!in_array($value, $this->values)) {
            throw new IndexException('Value in Map does not exists!');
        }

        $index = array_search($value, $this->values);

        return $this->keys[$index];
    }

    public function keys()
    {
        return $this->keys;
    }

    public function values()
    {
        return $this->values;
    }

    public function put($key, $value)
    {
        $this->validateValueForKeyType($key);
        $this->validateValueForValueType($value);

        if ($this->containsKey($key)) {
            $index = array_search($key, $this->keys);
            $this->values[$index] = $value;
        } else {
            $this->keys[] = $key;
            $this->values[] = $value;
        }

        if (!$this->isSynchronizedKeyAndValue($key, $value)) {
            throw new SynchronizeException('Error occurred under synchronize pair: key and value lists!');
        }

        return true;
    }

    public function putAll(MapInterface $map)
    {
        if (!$this->equalType($map->getKeyType(), $map->getValueType())) {
            throw new InvalidTypeException(
                sprintf(
                    'The map is incorrect type. %s for key and %s for value given. Must be key: %s and value: %s type!',
                    get_class($map->getKeyType()),
                    get_class($map->getValueType()),
                    get_class($this->getKeyType()),
                    get_class($this->getKeyType())
                )
            );
        }

        $keys = $map->keys();
        $values = $map->values();

        $collectionKeys = new \ArrayIterator($keys);
        foreach (new \IteratorIterator($collectionKeys) as $keyNumberOfKeys => $keyValue) {
            $this->put($keys[$keyNumberOfKeys], $values[$keyNumberOfKeys]);
        }

        return true;
    }

    public function remove($key)
    {
        $this->validateValueForKeyType($key);

        if (!$this->containsKey($key)) {
            return false;
        }

        $index = array_search($key, $this->keys);

        array_splice($this->keys, $index, 1);
        array_splice($this->values, $index, 1);

        if (!$this->isSynchronizedIndex()) {
            throw new SynchronizeException('Error occurred under synchronize pair: key and value lists!');
        }

        return true;
    }

    public function removeKeyAll(MapInterface $map)
    {
        if (!$this->containsKeyAll($map)) {
            return false;
        }

        $keys = $map->keys();

        $collectionKeys = new \ArrayIterator($keys);
        foreach (new \IteratorIterator($collectionKeys) as $index => $keyValue) {
            $this->remove($keyValue);
        }

        return true;
    }

    public function removeAll(MapInterface $map)
    {
        if (!$this->containsAll($map)) {
            return false;
        }

        $keys = $map->keys();

        $collectionKeys = new \ArrayIterator($keys);
        foreach (new \IteratorIterator($collectionKeys) as $index => $keyValue) {
            $this->remove($keyValue);
        }

        return true;
    }

    public function removeValue($value)
    {
        $this->validateValueForValueType($value);

        if (!$this->containsValue($value)) {
            return false;
        }

        $index = $this->getKeyOfValue($value);

        return $this->remove($index);
    }

    public function removeValueAll(MapInterface $map)
    {
        if (!$this->containsValueAll($map)) {
            return false;
        }

        $values = $map->values();

        $collectionValues = new \ArrayIterator($values);
        foreach (new \IteratorIterator($collectionValues) as $index => $value) {
            $this->removeValue($value);
        }

        return true;
    }

    public function containsKey($key)
    {
        $this->validateValueForKeyType($key);

        return in_array($key, $this->keys);
    }

    public function containsKeyAll(MapInterface $map)
    {
        $this->validateKeyType($map->getKeyType());
        $this->validateValueType($map->getValueType());

        $diffKeys = $this->diffArrays($map->keys(), $this->keys);

        return empty($diffKeys);
    }

    public function containsValueAll(MapInterface $map)
    {
        $this->validateKeyType($map->getKeyType());
        $this->validateValueType($map->getValueType());

        $diffValues = $this->diffArrays($map->values(), $this->values);

        return empty($diffValues);
    }

    public function containsValue($value)
    {
        $this->validateValueForValueType($value);

        return in_array($value, $this->values);
    }

    public function containsAll(MapInterface $map)
    {
        $this->validateKeyType($map->getKeyType());
        $this->validateValueType($map->getValueType());

        $diffKeys = $this->diffArrays($map->keys(), $this->keys);
        $diffValues = $this->diffArrays($map->values(), $this->values);

        return (empty($diffKeys) && (empty($diffValues)));
    }

    private function isSynchronizedKeyAndValue($key, $value)
    {
        $keyNumberOfKeys = array_search($key, $this->keys);
        $keyNumberOfValues = array_search($value, $this->values);

        return (bool)($keyNumberOfKeys == $keyNumberOfValues);
    }

    private function isSynchronizedIndex()
    {
        $keysCount = count($this->keys);
        $valuesCount = count($this->values);

        return ($keysCount === $valuesCount);
    }
}
