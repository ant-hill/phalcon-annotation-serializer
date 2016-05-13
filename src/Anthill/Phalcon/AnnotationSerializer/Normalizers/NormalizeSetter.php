<?php

namespace Anthill\Phalcon\AnnotationSerializer\Normalizers;


use Anthill\Phalcon\AnnotationSerializer\Normalizers\Setter\SetterStructure;
use Anthill\Phalcon\AnnotationSerializer\Structures\Property;

class NormalizeSetter implements NormalizeInterface
{
    /**
     * @param array|Property[] $propertyArray
     * @return SetterStructure
     */
    public function normalize(array $propertyArray)
    {
        $getterStructure = new SetterStructure();

        foreach ($propertyArray as $property) {
            $getterStructure->addFromProperty($property);
        }

        return $getterStructure;
    }
}