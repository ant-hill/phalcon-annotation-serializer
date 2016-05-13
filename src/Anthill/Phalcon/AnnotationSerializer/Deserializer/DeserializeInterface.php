<?php

namespace Anthill\Phalcon\AnnotationSerializer\Deserializer;


interface DeserializeInterface
{
    /**
     * @param $object
     * @param array $data
     * @param array $groups
     * @return mixed
     */
    public function deserialize($object, array $data, array $groups = array());
}