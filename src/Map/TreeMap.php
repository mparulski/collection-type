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

use CollectionType\Map\Sorted\SortedMapInterface;
use CollectionType\TypeValidator\TypeValidatorInterface;

final class TreeMap extends MapAbstract implements SortedMapInterface
{
    public function __construct(TypeValidatorInterface $keyType, TypeValidatorInterface $valueType)
    {
        parent::__construct($keyType, $valueType);
    }

    public function put($key, $value)
    {
        parent::put($key, $value);
        $this->sort();

        return true;
    }

    public function putAll(MapInterface $map)
    {
        parent::putAll($map);
        $this->sort();

        return true;
    }

    public function sort()
    {
        return array_multisort($this->keys, $this->values);
    }
}
