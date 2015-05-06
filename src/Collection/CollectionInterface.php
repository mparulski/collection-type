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

use CollectionType\Iterator\IteratorInterface;
use CollectionType\TypeValidator\TypeValidatorInterface;

interface CollectionInterface extends IteratorInterface
{
    public function equalValueType(TypeValidatorInterface $valueType);

    public function getValueType();

    public function equalType(TypeValidatorInterface $type);

    public function equals(CollectionInterface $collection);

    public function getAll();

    public function toArray();

    public function add($value);

    public function remove($value);

    public function removeAll(CollectionInterface $collection);

    public function removeAny(CollectionInterface $collection);

    public function contains($value);

    public function containsAll(CollectionInterface $collection);

    public function getDifference(CollectionInterface $collection);
}
