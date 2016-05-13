<?php

namespace Anthill\Phalcon\AnnotationSerializer;


use Anthill\Phalcon\AnnotationSerializer\Processors\DeserializerProcessor;
use Anthill\Phalcon\AnnotationSerializer\Processors\ProcessorInterface;
use Anthill\Phalcon\AnnotationSerializer\Processors\PropertyProcessor;
use Anthill\Phalcon\AnnotationSerializer\Processors\SerializerProcessor;
use Anthill\Phalcon\AnnotationSerializer\Processors\VirtualPropertySerializerProcessor;
use Phalcon\Annotations\Adapter as AnnotationAdapter;

class AnnotationProcessor
{
    /**
     * @var AnnotationAdapter
     */
    private $reader;

    public function __construct(AnnotationAdapter $reader)
    {
        $this->reader = $reader;
    }

    /**
     * @return array| ProcessorInterface
     */
    private function getPropertyProcessors()
    {
        return array(
            PropertyProcessor::getAnnotationName() => new PropertyProcessor(),
            DeserializerProcessor::getAnnotationName() => new DeserializerProcessor(),
            SerializerProcessor::getAnnotationName() => new SerializerProcessor(),
            VirtualPropertySerializerProcessor::getAnnotationName() => new VirtualPropertySerializerProcessor()
        );
    }

    /**
     * @return array| ProcessorInterface
     */
    private function getMethodProcessors()
    {
        return array(
            VirtualPropertySerializerProcessor::getAnnotationName() => new VirtualPropertySerializerProcessor()
        );
    }


    /**
     * @param $className
     * @return array
     */
    public function process($className)
    {
        $propertyProcessors = $this->getPropertyProcessors();
        $methodProcessors = $this->getMethodProcessors();
        $reflector = $this->reader->get($className);
        $propertiesAnnotations = $reflector->getPropertiesAnnotations();

        $structs = [];

        foreach ($propertiesAnnotations as $propertyName => $propertyAnnotations) {
            $annotations = $propertyAnnotations->getAnnotations();
            foreach ($annotations as $annotation) {
                $name = $annotation->getName();
                if (!array_key_exists($name, $propertyProcessors)) {
                    continue;
                }
                /* @var $processor ProcessorInterface */
                $processor = $propertyProcessors[$name];
                $structs[] = $processor->process($propertyName, $annotation);
            }
        }

        $methodAnnotations = $reflector->getMethodsAnnotations();
        foreach ($methodAnnotations as $propertyName => $propertyAnnotations) {
            $annotations = $propertyAnnotations->getAnnotations();
            foreach ($annotations as $annotation) {
                $name = $annotation->getName();
                if (!array_key_exists($name, $methodProcessors)) {
                    continue;
                }
                /* @var $processor ProcessorInterface */
                $processor = $methodProcessors[$name];
                $structs[] = $processor->process($propertyName, $annotation);
            }
        }
        return $structs;
    }

}