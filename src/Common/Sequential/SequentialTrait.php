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

namespace CollectionType\Common\Sequential;

use CollectionType\Collection\CollectionInterface;
use CollectionType\Exception\IndexException;

trait SequentialTrait
{

    public function getKey($value)
    {
        $this->validateValueForValueType($value);

        return array_search($value, $this->values);
    }

    private function setValueIntoIndex($index, $value)
    {
        $this->validateIndex($index);

        $newElement[] = $value;

        $firstPiece = array_slice($this->values, 0, $index);
        $secondPiece = array_slice($this->values, $index);

        $this->clear();
        $this->values = array_merge($firstPiece, $newElement, $secondPiece);

        return true;
    }

    private function setCollectionIntoIndex($index, CollectionInterface $collection)
    {
        $this->validateIndex($index);

        $firstPiece = array_slice($this->values, 0, $index);
        $secondPiece = array_slice($this->values, $index);

        $this->clear();
        $this->values = array_merge($firstPiece, $collection->getAll(), $secondPiece);

        return true;
    }

    private function validateIndex($index)
    {
        if (!is_int($index) || $index < 0) {
            throw new IndexException('invalid index value! Index must be positive integer!');
        }

        return true;
    }
}
