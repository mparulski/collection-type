<?php
namespace CollectionType\Type;

class ObjectType implements TypeInterface
{

    public function isValid($value)
    {
        return is_object($value);
    }
}
