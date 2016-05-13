<?php

namespace Anthill\Phalcon\AnnotationSerializer\Normalizers;


use Anthill\Phalcon\AnnotationSerializer\Normalizers\Getter\GetterStructure;
use Anthill\Phalcon\AnnotationSerializer\Normalizers\Setter\SetterStructure;

class GetterSetterStructure
{

    /**
     * @var GetterStructure
     */
    private $getter;

    /**
     * @var SetterStructure
     */
    private $setter;

    /**
     * @return GetterStructure
     */
    public function getGetter()
    {
        return $this->getter;
    }

    /**
     * @param GetterStructure $getter
     */
    public function setGetter(GetterStructure $getter)
    {
        $this->getter = $getter;
    }

    /**
     * @return SetterStructure
     */
    public function getSetter()
    {
        return $this->setter;
    }

    /**
     * @param SetterStructure $setter
     */
    public function setSetter(SetterStructure $setter)
    {
        $this->setter = $setter;
    }


}