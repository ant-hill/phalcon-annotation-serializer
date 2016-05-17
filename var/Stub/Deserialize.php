<?php

/**
 * Class Serializer
 * @Annotation
 * @Target({"PROPERTY"})
 */
class Deserialize
{
    public $getter;
    public $name;
    public $type;
    public $type_arguments=array();
    public $groups;
}