<?php

/**
 * Class Serializer
 * @Annotation
 * @Target({"PROPERTY"})
 */
class Serialize
{
    public $setter;
    public $name;
    public $type;
    public $type_arguments=array();
    public $groups;
}