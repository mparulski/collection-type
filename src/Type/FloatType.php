<?php
namespace CollectionType\Type;

class FloatType implements TypeInterface
{

    public function isValid($value)
    {
        return is_float($value);
    }
}
