<?php

namespace Anthill\Phalcon\AnnotationSerializer\Convertors;


interface ConvertorInterface
{
    /**
     * @param $value
     * @return mixed
     */
    public function convert($value);
}