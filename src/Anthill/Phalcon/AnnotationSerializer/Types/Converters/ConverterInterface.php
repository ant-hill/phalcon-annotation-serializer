<?php
namespace Anthill\Phalcon\AnnotationSerializer\Types\Converters;


interface ConverterInterface
{
    /**
     * @param $value
     * @param $arguments
     * @return mixed
     */
    public function from($value,$arguments);

    /**
     * @param $value
     * @param $arguments
     * @return mixed
     */
    public function to($value,$arguments);
}