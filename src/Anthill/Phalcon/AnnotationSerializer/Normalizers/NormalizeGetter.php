<?php

namespace Anthill\Phalcon\AnnotationSerializer\Normalizers;


use Anthill\Phalcon\AnnotationSerializer\Normalizers\Getter\GetterStructure;
use Anthill\Phalcon\AnnotationSerializer\Structures\Property;

class NormalizeGetter implements NormalizeInterface
{
    /**
     * @param array|Property[] $propertyArray
     * @return GetterStructure
     */
    public function normalize(array $propertyArray)
    {
        $getterStructure = new GetterStructure();

        foreach ($propertyArray as $property) {
            $getterStructure->addFromProperty($property);
        }

        return $getterStructure;
    }
}