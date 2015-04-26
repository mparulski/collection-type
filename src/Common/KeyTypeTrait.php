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

namespace CollectionType\Common;

use CollectionType\Exception\InvalidTypeException;
use CollectionType\TypeValidator\TypeValidatorInterface;

trait KeyTypeTrait
{
    /** @var $keyType \CollectionType\TypeValidator\TypeValidatorInterface */
    private $keyType;

    public function equalKeyType(TypeValidatorInterface $keyType)
    {
        return ($this->keyType == $keyType);
    }

    public function getKeyType()
    {
        return $this->keyType;
    }

    private function validateKeyType($key)
    {
        if (!$this->keyType->isValid($key)) {
            throw new InvalidTypeException(sprintf('The key is incorrect type. %s given!', gettype($key)));
        }

        return true;
    }

    private function setKeyType(TypeValidatorInterface $keyType)
    {
        $this->keyType = $keyType;
    }
}
