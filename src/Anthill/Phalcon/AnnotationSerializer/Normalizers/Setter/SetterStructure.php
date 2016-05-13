<?php

namespace Anthill\Phalcon\AnnotationSerializer\Normalizers\Setter;


use Anthill\Phalcon\AnnotationSerializer\Structures\Field;
use Anthill\Phalcon\AnnotationSerializer\Structures\Property;

class SetterStructure
{
    /**
     * @var array|SetterGroupNormalizeStructure[]
     */
    private $groups = array();
    private $setters = array();


    public function addFromProperty(Property $property)
    {
        if (!$property->getSetter() instanceof Field) {
            return;
        }

        if($this->addSetter($property)){
            $this->addGroups($property->getGroups(), $property->getName());
        }
    }


    private function addSetter(Property $property)
    {
        $idx = $property->getName();
        $setter = $property->getSetter();
        if (!$setter instanceof Field) {
            return false;
        }
        $data = SetterNormalizeStructure::create();
        $data->setType($property->getType())->setField($setter);
        $this->setters[$idx] = $data;
        return true;
    }

    private function addGroups($groups, $field)
    {
        if (!is_array($groups)) {
            return;
        }
        foreach ($groups as $groupName) {
            if (!array_key_exists($groupName, $this->groups)) {
                $this->groups[$groupName] = SetterGroupNormalizeStructure::create();
            }
            /* @var $groupObject SetterGroupNormalizeStructure */
            $groupObject = $this->groups[$groupName];
            $groupObject->addField($field);
        }
    }

    /**
     * @return SetterStructure
     */
    public static function create()
    {
        return new self();
    }

    /**
     * @param $name
     * @return mixed
     */
    public function groupExists($name)
    {
        return array_key_exists($name, $this->groups);
    }

    /**
     * @param $name
     * @return SetterGroupNormalizeStructure
     */
    public function getGroup($name)
    {
        return $this->groups[$name];
    }

    /**
     * @return array|SetterNormalizeStructure[]
     */
    public function getGetters()
    {
        return $this->setters;
    }

    /**
     * @return array
     */
    public function getGettersFields()
    {
        return array_keys($this->setters);
    }

    /**
     * @param $field
     * @return SetterNormalizeStructure
     */
    public function getGetterByField($field)
    {
        return $this->setters[$field];
    }
}