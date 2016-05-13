<?php

namespace Anthill\Phalcon\AnnotationSerializer\Structures;

/**
 * Class Field
 * @package Anthill\Phalcon\AnnotationSerializer\Structures
 */
class Field
{
    const TYPE_PROPERTY = 'property';
    const TYPE_METHOD = 'method';

    private $type;
    private $name;

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     * @return $this
     */
    public function setType($type)
    {
        $this->type = $type;
        return $this;
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
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return static
     */
    public static function create()
    {
        return new static();
    }
}