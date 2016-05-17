<?php

namespace Anthill\Phalcon\AnnotationSerializer\Types\Converters;

class StringConverter implements ConverterInterface
{
    /**
     * @param $value
     * @param $arguments
     * @return string
     */
    public function from($value, $arguments)
    {
        return (string)$value;
    }

    /**
     * @param $value
     * @param $arguments
     * @return string
     */
    public function to($value, $arguments)
    {
        return (string)$value;
    }
}