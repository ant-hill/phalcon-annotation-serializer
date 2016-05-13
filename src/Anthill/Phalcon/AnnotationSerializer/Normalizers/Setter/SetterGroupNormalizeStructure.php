<?php

namespace Anthill\Phalcon\AnnotationSerializer\Normalizers\Setter;


class SetterGroupNormalizeStructure
{

    private $fields = array();


    public function addField($field)
    {
        $this->fields[$field] = 1;
    }

    public function getFields()
    {
        return array_keys($this->fields);
    }

    /**
     * @return SetterNormalizeStructure
     */
    public static function create()
    {
        return new self();
    }
}