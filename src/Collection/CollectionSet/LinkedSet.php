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

namespace CollectionType\Collection\CollectionSet;

use CollectionType\Collection\CollectionInterface;
use CollectionType\Collection\CollectionSet\Sequential\SequentialSetInterface;
use CollectionType\Common\Sequential\SequentialTrait;
use CollectionType\TypeValidator\TypeValidatorInterface;

final class LinkedSet extends SetAbstract implements SequentialSetInterface
{

    use SequentialTrait;

    public function __construct(TypeValidatorInterface $type)
    {
        parent::__construct($type);
    }

    public function set($index, $value)
    {
        if ($this->contains($value)) {
            return false;
        }

        return $this->setValueIntoIndex($index, $value);
    }

    public function setAll($index, CollectionInterface $collection)
    {
        $this->validateValueType($collection->getValueType());

        $uniqueCollection = $collection->getDifference($this);

        return $this->setCollectionIntoIndex($index, $uniqueCollection);
    }
}
