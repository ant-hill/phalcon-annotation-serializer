<?php

namespace Anthill\Phalcon\AnnotationSerializer\Processors;


use Anthill\Phalcon\AnnotationSerializer\Structures\Property;

class VirtualPropertySerializerProcessor extends PropertyProcessor
{

    public static function getAnnotationName()
    {
        return 'VirtualPropertySerialize';
    }

    /**
     * @param $propertyName
     * @param \Phalcon\Annotations\Annotation $annotation
     * @return Property
     */
    public function process($propertyName, \Phalcon\Annotations\Annotation $annotation)
    {
        $property = Property::create();
        $this->getter($property, null, $propertyName);
        $this->groups($property, $annotation->getArgument('groups'));
        $this->type($property, $annotation->getArgument('type'));
        $this->typeArguments($property, $annotation->getArgument('type_arguments'));
        $property->setName($annotation->getArgument('name'));

        return $property;
    }
}