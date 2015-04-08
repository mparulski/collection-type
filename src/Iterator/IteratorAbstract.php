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

namespace CollectionType\Iterator;

use ArrayIterator;

abstract class IteratorAbstract implements IteratorInterface
{
    protected $values = [];

    public function getIterator()
    {
        return new ArrayIterator($this->values);
    }

    public function count()
    {
        return count($this->values);
    }

    public function clear()
    {
        $this->values = [];
    }

    public function isEmpty()
    {
        return empty($this->values);
    }

    public function current()
    {
        return current($this->values);
    }

    public function next()
    {
        return next($this->values);
    }

    public function key()
    {
        return key($this->values);
    }

    public function first()
    {
        return reset($this->values);
    }

    public function last()
    {
        return end($this->values);
    }

    public function rewind()
    {
        return reset($this->values);
    }
}
