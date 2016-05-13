<?php

namespace Anthill\Phalcon\AnnotationSerializer;

use Anthill\Phalcon\AnnotationSerializer\Deserializer\ArrayDeserializer;
use Anthill\Phalcon\AnnotationSerializer\Normalizers\GetterSetterStructure;
use Anthill\Phalcon\AnnotationSerializer\Normalizers\NormalizerManager;
use Anthill\Phalcon\AnnotationSerializer\Serializer\Exceptions\SerializeException;
use Anthill\Phalcon\AnnotationSerializer\Serializer\JsonSerializer;

class SerializeManager implements SerializeManagerInterface
{
    /**
     * @var array|GetterSetterStructure[]
     */
    private $getterSetterStructure = array();
    /**
     * @var AnnotationProcessor
     */
    private $annotationProcessor;
    /**
     * @var Normalizers\NormalizerManager
     */
    private $normalizerManager;


    /**
     * SerializeManager constructor.
     * @param \Anthill\Phalcon\AnnotationSerializer\AnnotationProcessor $annotationProcessor
     * @param NormalizerManager $normalizerManager
     */
    public function __construct(AnnotationProcessor $annotationProcessor, NormalizerManager $normalizerManager)
    {
        $this->annotationProcessor = $annotationProcessor;
        $this->normalizerManager = $normalizerManager;
    }

    /**
     * @param $className
     * @return GetterSetterStructure
     */
    private function getGetterSetterStructureForObject($className)
    {
        if (array_key_exists($className, $this->getterSetterStructure)) {
            return $this->getterSetterStructure[$className];
        }

        $properties = $this->annotationProcessor->process($className);
        $getterSetterStructure = $this->normalizerManager->normalize($properties);
        $this->getterSetterStructure[$className] = $getterSetterStructure;
        return $this->getterSetterStructure[$className];
    }

    /**
     * @param $object
     * @param array $groups
     * @return mixed
     * @throws SerializeException
     */
    public function serialize($object, array $groups = array())
    {
        if (!is_object($object)) {
            throw new SerializeException('First parameter must be an object');
        }
        $structure = $this->getGetterSetterStructureForObject(get_class($object));
        $serializer = new JsonSerializer($structure->getGetter());
        return $serializer->serialize($object, $groups);
    }

    /**
     * @param $object
     * @param array $data
     * @param array $groups
     * @return mixed
     * @throws \Anthill\Phalcon\AnnotationSerializer\Deserializer\Exceptions\DeserializeException
     * @throws SerializeException
     */
    public function deserialize($object, array $data, array $groups = array())
    {
        if (!is_object($object)) {
            throw new SerializeException('First parameter must be an object');
        }
        $structure = $this->getGetterSetterStructureForObject(get_class($object));
        $serializer = new ArrayDeserializer($structure->getSetter());
        return $serializer->deserialize($object, $data, $groups);
    }
}