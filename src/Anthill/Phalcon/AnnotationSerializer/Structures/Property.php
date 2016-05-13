<?php

namespace Anthill\Phalcon\AnnotationSerializer\Structures;

class Property
{
    private $getter;
    private $setter;
    private $name;
    private $type;
    private $groups;

    /**
     * @return mixed
     */
    public function getGetter()
    {
        return $this->getter;
    }

    /**
     * @param mixed $getter
     */
    public function setGetter($getter)
    {
        $this->getter = $getter;
    }

    /**
     * @return mixed
     */
    public function getSetter()
    {
        return $this->setter;
    }

    /**
     * @param mixed $setter
     */
    public function setSetter($setter)
    {
        $this->setter = $setter;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return mixed
     */
    public function getGroups()
    {
        return $this->groups;
    }

    /**
     * @param mixed $groups
     */
    public function setGroups($groups)
    {
        $this->groups = $groups;
    }

    /**
     * @return Property
     */
    public static function create(){
        return new self();
    }
}