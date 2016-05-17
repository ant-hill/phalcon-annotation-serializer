<?php

namespace Anthill\Phalcon\AnnotationSerializer\Normalizers\Getter;


use Anthill\Phalcon\AnnotationSerializer\Structures\Field;

class GetterNormalizeStructure
{
    private $type;
    private $typeArguments = array();

    /**
     * @var Field
     */
    private $field;

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     * @return GetterNormalizeStructure
     */
    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return Field
     */
    public function getField()
    {
        return $this->field;
    }

    /**
     * @param Field $field
     * @return GetterNormalizeStructure
     */
    public function setField(Field $field)
    {
        $this->field = $field;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTypeArguments()
    {
        return $this->typeArguments;
    }

    /**
     * @param mixed $typeArguments
     * @return GetterNormalizeStructure
     */
    public function setTypeArguments($typeArguments)
    {
        $this->typeArguments = $typeArguments;
        return $this;
    }

    /**
     * @return GetterNormalizeStructure
     */
    public static function create(){
        return new self();
    }
}