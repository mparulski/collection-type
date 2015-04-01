<?php
namespace CollectionType\Type;

interface TypeInterface
{

    /**
     * @return boolean
     */
    public function isValid($value);
}
