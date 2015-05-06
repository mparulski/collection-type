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

use CollectionType\TypeValidator\TypeValidatorInterface;

interface MapInterface
{
    public function count();

    public function clear();

    public function isEmpty();

    public function equalKeyType(TypeValidatorInterface $valueType);

    public function getKeyType();

    public function equalValueType(TypeValidatorInterface $valueType);

    public function getValueType();

    public function equalType(TypeValidatorInterface $keyType, TypeValidatorInterface $valueType);

    public function get($key);

    public function getKeyOfValue($value);

    public function keys();

    public function values();

    public function put($key, $value);

    public function putAll(MapInterface $map);

    public function remove($key);

    public function removeValue($value);

    public function removeValueAll(MapInterface $map);

    public function containsKey($key);

    public function containsValue($value);

    public function containsAll(MapInterface $map);

    public function equals(MapInterface $map);
}
