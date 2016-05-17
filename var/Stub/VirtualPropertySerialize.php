<?php

/**
 * Class Serializer
 * @Annotation
 * @Target({"METHOD"})
 */
class VirtualPropertySerialize
{
    public $name;
    public $type;
    public $type_arguments=array();
    public $groups;
}