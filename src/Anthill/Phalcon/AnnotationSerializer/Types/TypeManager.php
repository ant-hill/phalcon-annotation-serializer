<?php

namespace Anthill\Phalcon\AnnotationSerializer\Types;


use Anthill\Phalcon\AnnotationSerializer\Types\Converters\ConverterInterface;

class TypeManager
{
    /**
     * @var array| ConverterInterface[]
     */
    private $converters;

    /**
     * TypeManager constructor.
     * @param array $converters
     */
    public function __construct(array $converters = array())
    {
        $this->converters = $converters;
    }

    /**
     * @param $name
     * @return bool
     */
    public function has($name)
    {
        return array_key_exists($name, $this->converters);
    }

    /**
     * @param $name
     * @param ConverterInterface $converter
     */
    public function set($name, ConverterInterface $converter)
    {
        $this->converters[$name] = $converter;
    }

    /**
     * @param $type
     * @param $value
     * @param $arguments
     * @return mixed|null
     */
    public function from($type, $value, $arguments)
    {
        if (array_key_exists($type, $this->converters)) {
            return $this->converters[$type]->from($value, $arguments);
        }
        return null;
    }

    /**
     * @param $type
     * @param $value
     * @param $arguments
     * @return mixed|null
     */
    public function to($type, $value, $arguments)
    {
        if (array_key_exists($type, $this->converters)) {
            return $this->converters[$type]->to($value, $arguments);
        }
        return null;
    }
}