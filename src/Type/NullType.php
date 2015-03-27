<?php
namespace CollectionType\Type;

class NullType implements TypeInterface
{

    public function isValid($value)
    {
        return is_null($value);
    }
}
