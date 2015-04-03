<?php
/*
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

namespace Fake;


use CollectionType\CollectionAbstract;
use CollectionType\CollectionInterface;
use CollectionType\Exception\InvalidTypeException;
use CollectionType\Type\TypeInterface;

/**
 * @codeCoverageIgnore
 */
class CollectionAbstractFake extends CollectionAbstract
{
    public function __construct(TypeInterface $type)
    {
        parent::__construct($type);
    }

    /**
     * Fake method
     *
     * @param $value
     */
    public function add($value)
    {
        $this->values[] = $value;
    }

    /**
     * Fake method
     *
     * @param CollectionInterface $collection
     */
    public function addAll(CollectionInterface $collection)
    {
        throw new InvalidTypeException('This is fake method!');
    }
}