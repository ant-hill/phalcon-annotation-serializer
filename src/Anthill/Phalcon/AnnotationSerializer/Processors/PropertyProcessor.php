<?php

namespace Anthill\Phalcon\AnnotationSerializer\Processors;


use Anthill\Phalcon\AnnotationSerializer\Structures\Field;
use Anthill\Phalcon\AnnotationSerializer\Structures\Property;

class PropertyProcessor implements ProcessorInterface
{

    public static function getAnnotationName()
    {
        return 'Property';
    }


    /**
     * @param $propertyName
     * @param \Phalcon\Annotations\Annotation $annotation
     * @return Property
     */
    public function process($propertyName, \Phalcon\Annotations\Annotation $annotation)
    {
        $property = Property::create();

        $this->setter($property, $propertyName, $annotation->getArgument('setter'));
        $this->getter($property, $propertyName, $annotation->getArgument('getter'));
        $this->groups($property, $annotation->getArgument('groups'));
        $this->type($property, $annotation->getArgument('type'));
        $this->name($property, $annotation->getArgument('name'), $annotation->getArgument(0), $propertyName);

        return $property;
    }


    protected function setter(Property $property, $name, $setter)
    {
        if ($setter) {
            $property->setSetter(Field::create()->setType(Field::TYPE_METHOD)->setName($setter));
            return;
        }
        $property->setSetter(Field::create()->setType(Field::TYPE_PROPERTY)->setName($name));
    }

    protected function name(Property $property, $name, $alternativeName, $propertyName)
    {
        if ($name) {
            $property->setName($name);
            return;
        }
        if ($alternativeName) {
            $property->setName($alternativeName);
            return;
        }
        $property->setName($propertyName);
    }

    protected function groups(Property $property, $groups)
    {
        if (!$groups) {
            return;
        }

        if (!is_array($groups)) {
            $groups = array($groups);
        }

        $property->setGroups($groups);
    }

    protected function type(Property $property, $type)
    {
        if ($type) {
            $property->setType($type);
        }
    }

    protected function getter(Property $property, $name, $getter)
    {
        if ($getter) {
            $property->setGetter(Field::create()->setType(Field::TYPE_METHOD)->setName($getter));
            return;
        }
        $property->setGetter(Field::create()->setType(Field::TYPE_PROPERTY)->setName($name));

    }
}