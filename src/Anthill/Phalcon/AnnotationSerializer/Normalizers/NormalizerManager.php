<?php

namespace Anthill\Phalcon\AnnotationSerializer\Normalizers;


use Anthill\Phalcon\AnnotationSerializer\Structures\Property;

class NormalizerManager
{
    /**
     * @var NormalizeGetter
     */
    private $normalizeGetter;
    /**
     * @var NormalizeSetter
     */
    private $normalizeSetter;

    public function __construct(NormalizeGetter $normalizeGetter, NormalizeSetter $normalizeSetter)
    {
        $this->normalizeGetter = $normalizeGetter;
        $this->normalizeSetter = $normalizeSetter;
    }

    /**
     * @param array|Property[] $properties
     * @return GetterSetterStructure
     */
    public function normalize($properties)
    {
        $getterNormalizer = $this->normalizeGetter;
        $setterNormalizer = $this->normalizeSetter;
        $getterSetterStructure = new GetterSetterStructure();
        $getterSetterStructure->setGetter($getterNormalizer->normalize($properties));
        $getterSetterStructure->setSetter($setterNormalizer->normalize($properties));

        return $getterSetterStructure;
    }
}