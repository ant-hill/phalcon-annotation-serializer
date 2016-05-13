<?php

namespace Anthill\Phalcon\AnnotationSerializer\Processors;


use Anthill\Phalcon\AnnotationSerializer\Structures\Field;
use Anthill\Phalcon\AnnotationSerializer\Structures\Property;

class DeserializerProcessor extends PropertyProcessor
{

    public static function getAnnotationName()
    {
        return 'Deserialize';
    }

    /**
     * @param $propertyName
     * @param \Phalcon\Annotations\Annotation $annotation
     * @return Property
     */
    public function process($propertyName, \Phalcon\Annotations\Annotation $annotation)
    {
        $property = Property::create();

        $this->setter($property, $propertyName, $annotation->getArgument('getter'));
        $this->groups($property, $annotation->getArgument('groups'));
        $this->type($property, $annotation->getArgument('type'));
        $this->name($property, $annotation->getArgument('name'), $annotation->getArgument(0), $propertyName);

        return $property;
    }
}