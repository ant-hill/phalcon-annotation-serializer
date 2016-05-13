<?php

namespace Anthill\Phalcon\AnnotationSerializer\Normalizers;


use Anthill\Phalcon\AnnotationSerializer\Structures\Property;

interface NormalizeInterface
{

    /**
     * @param array|Property[] $propertyArray
     * @return array
     */
    public function normalize(array $propertyArray);
}