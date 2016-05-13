<?php

/**
 * Class Serializer
 * @Annotation
 * @Target({"PROPERTY"})
 */
class Property
{
    public $getter;
    public $setter;
    public $name;
    public $type;
    public $groups;
}