<?php

namespace Anthill\Phalcon\AnnotationSerializer;

use Anthill\Phalcon\AnnotationSerializer\Normalizers\GetterSetterStructure;
use Anthill\Phalcon\AnnotationSerializer\Normalizers\NormalizerManager;
use Anthill\Phalcon\AnnotationSerializer\Serializer\Exceptions\SerializeException;
use Anthill\Phalcon\AnnotationSerializer\Serializer\SerializeInterface;
use Anthill\Phalcon\AnnotationSerializer\Types\TypeManager;

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
     * @var string
     */
    private $serializerClass;
    /**
     * @var string
     */
    private $deserializerClass;
    /**
     * @var TypeManager
     */
    private $typeManager;


    /**
     * SerializeManager constructor.
     * @param \Anthill\Phalcon\AnnotationSerializer\AnnotationProcessor $annotationProcessor
     * @param NormalizerManager $normalizerManager
     * @param $serializerClass
     * @param $deserializerClass
     * @param TypeManager $typeManager
     */
    public function __construct(
        AnnotationProcessor $annotationProcessor,
        NormalizerManager $normalizerManager,
        $serializerClass,
        $deserializerClass,
        TypeManager $typeManager
    ) {
        $this->annotationProcessor = $annotationProcessor;
        $this->normalizerManager = $normalizerManager;
        $this->serializerClass = $serializerClass;
        $this->deserializerClass = $deserializerClass;
        $this->typeManager = $typeManager;
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
        if (is_object($object)) {
            return $this->serializeObject($object, $groups);
        }

        if (is_array($object)) {
            return $this->serializeArray($object, $groups);
        }
    }

    public function serializeArray(array $data, array $groups = array())
    {
        $resultArray = array();
        foreach ($data as $key => $item) {
            if (is_object($item)) {
                $resultArray[$key] = $this->serializeObject($item, $groups);
            }
            if (is_array($item)) {
                $resultArray[$key] = $this->serializeArray($item, $groups);
            }
            if (is_scalar($item)) {
                $resultArray[$key] = $item;
            }
        }
        return $resultArray;
    }

    private function serializeObject($object, array $groups = array())
    {
        if (!is_object($object)) {
            throw new SerializeException('First parameter must be an object');
        }
        //todo: cache for getters and setters
        $structure = $this->getGetterSetterStructureForObject(get_class($object));
        $serializerClass = $this->serializerClass;
        /* @var $serializer SerializeInterface */
        $serializer = new $serializerClass($structure->getGetter(),$this->typeManager);
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
        $deserializerClass = $this->deserializerClass;
        $structure = $this->getGetterSetterStructureForObject(get_class($object));
        /* @var $deserializer \Anthill\Phalcon\AnnotationSerializer\Deserializer\DeserializeInterface */
        $deserializer = new $deserializerClass($structure->getSetter(),$this->typeManager);
        return $deserializer->deserialize($object, $data, $groups);
    }
}