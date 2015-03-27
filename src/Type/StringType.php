<?php
namespace CollectionType\Type;

class StringType implements TypeInterface
{

    public function isValid($value)
    {
        return is_string($value);
    }
}
