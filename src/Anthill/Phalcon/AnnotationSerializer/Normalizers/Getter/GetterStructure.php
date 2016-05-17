<?php

namespace Anthill\Phalcon\AnnotationSerializer\Normalizers\Getter;


use Anthill\Phalcon\AnnotationSerializer\Structures\Field;
use Anthill\Phalcon\AnnotationSerializer\Structures\Property;

class GetterStructure
{
    /**
     * @var array|GetterGroupNormalizeStructure[]
     */
    private $groups = array();

    /**
     * @var array|GetterNormalizeStructure[]
     */
    private $getters = array();


    public function addFromProperty(Property $property)
    {
        if (!$property->getGetter() instanceof Field) {
            return;
        }

        if ($this->addGetter($property)) {
            $this->addGroups($property->getGroups(), $property->getName());
        }
    }


    private function addGetter(Property $property)
    {
        $idx = $property->getName();
        $getter = $property->getGetter();
        if (!$getter instanceof Field) {
            return false;
        }
        $data = GetterNormalizeStructure::create();
        $data->setType($property->getType());
        $data->setTypeArguments($property->getTypeArguments());
        $data->setField($getter);
        $this->getters[$idx] = $data;
        return true;
    }

    private function addGroups($groups, $field)
    {
        if (!is_array($groups)) {
            return;
        }
        foreach ($groups as $groupName) {
            if (!array_key_exists($groupName, $this->groups)) {
                $this->groups[$groupName] = GetterGroupNormalizeStructure::create();
            }
            /* @var $groupObject GetterGroupNormalizeStructure */
            $groupObject = $this->groups[$groupName];
            $groupObject->addField($field);
        }
    }

    /**
     * @return GetterGroupNormalizeStructure[]|array
     */
    public function getGroups()
    {
        return $this->groups;
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
     * @return GetterGroupNormalizeStructure
     */
    public function getGroup($name)
    {
        return $this->groups[$name];
    }

    /**
     * @return GetterStructure
     */
    public static function create()
    {
        return new self();
    }

    /**
     * @return array|GetterNormalizeStructure[]
     */
    public function getGetters()
    {
        return $this->getters;
    }

    /**
     * @return array
     */
    public function getGettersFields()
    {
        return array_keys($this->getters);
    }

    /**
     * @param $field
     * @return GetterNormalizeStructure
     */
    public function getGetterByField($field)
    {
        return $this->getters[$field];
    }
}