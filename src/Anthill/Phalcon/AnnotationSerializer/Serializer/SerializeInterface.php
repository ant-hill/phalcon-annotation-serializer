<?php

namespace Anthill\Phalcon\AnnotationSerializer\Serializer;


interface SerializeInterface
{
    /**
     * @param $object
     * @param array $groups
     * @return mixed
     */
    public function serialize($object, array $groups = array());
}