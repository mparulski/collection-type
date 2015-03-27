<?php
namespace CollectionType\Type;

class IntegerType implements TypeInterface
{

    public function isValid($value)
    {
        return is_integer($value);
    }
}
