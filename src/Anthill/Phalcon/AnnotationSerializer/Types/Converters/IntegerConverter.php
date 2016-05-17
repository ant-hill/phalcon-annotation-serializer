<?php

namespace Anthill\Phalcon\AnnotationSerializer\Types\Converters;


class IntegerConverter implements ConverterInterface
{

    /**
     * @param $value
     * @param $arguments
     * @return int
     */
    public function from($value,$arguments)
    {
        return (int)$value;
    }

    /**
     * @param $value
     * @param $arguments
     * @return mixed
     */
    public function to($value,$arguments)
    {
        return (int)$value;
    }
}