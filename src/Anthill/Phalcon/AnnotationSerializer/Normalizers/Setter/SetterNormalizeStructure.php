<?php

namespace Anthill\Phalcon\AnnotationSerializer\Normalizers\Setter;


use Anthill\Phalcon\AnnotationSerializer\Structures\Field;

class SetterNormalizeStructure
{
    private $type;

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
     * @return SetterNormalizeStructure
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
     * @return SetterNormalizeStructure
     */
    public function setField(Field $field)
    {
        $this->field = $field;
        return $this;
    }

    /**
     * @return SetterNormalizeStructure
     */
    public static function create(){
        return new self();
    }
}