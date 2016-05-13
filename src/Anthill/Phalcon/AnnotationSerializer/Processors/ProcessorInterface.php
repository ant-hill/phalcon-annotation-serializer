<?php

namespace Anthill\Phalcon\AnnotationSerializer\Processors;


use Anthill\Phalcon\AnnotationSerializer\Structures\Property;

interface ProcessorInterface
{
    public static function getAnnotationName();

    /**
     * @param $name
     * @param \Phalcon\Annotations\Annotation $annotation
     * @return Property
     */
    public function process($name, \Phalcon\Annotations\Annotation $annotation);
}