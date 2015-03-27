<?php
namespace CollectionType\Type;

class ArrayType implements TypeInterface
{

    public function isValid($value)
    {
        return is_array($value);
    }
}
