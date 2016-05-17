<?php

namespace Anthill\Phalcon\AnnotationSerializer\Types\Converters;


class BooleanConverter implements ConverterInterface
{

    /**
     * @param $value
     * @param $arguments
     * @return mixed
     */
    public function from($value,$arguments)
    {
        return (bool)$value;
    }

    /**
     * @param $value
     * @param $arguments
     * @return mixed
     */
    public function to($value,$arguments)
    {
        return (bool)$value;
    }
}