<?php

namespace Anthill\Phalcon\AnnotationSerializer\Normalizers\Getter;


class GetterGroupNormalizeStructure
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
     * @return GetterNormalizeStructure
     */
    public static function create()
    {
        return new self();
    }
}