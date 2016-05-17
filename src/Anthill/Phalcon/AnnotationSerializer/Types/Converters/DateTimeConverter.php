<?php

namespace Anthill\Phalcon\AnnotationSerializer\Types\Converters;


class DateTimeConverter implements ConverterInterface
{

    const DEFAULT_FORMAT = \DateTime::ISO8601;

    /**
     * @param $value
     * @param $arguments
     * @return mixed
     */
    public function from($value, $arguments)
    {
        if (!is_string($value)) {
            return false;
        }
        $format = $this->getFormat($arguments);
        $result = \DateTime::createFromFormat($format, $value);
        if (!$result) {
            return null;
        }
        return $result;
    }

    /**
     * @param \DateTime $value
     * @param $arguments
     * @return mixed
     */
    public function to($value, $arguments)
    {
        if (!$value) {
            return null;
        }
        $format = $this->getFormat($arguments);
        return $value->format($format);
    }

    private function getFormat($arguments)
    {
        if (!is_array($arguments)) {
            return self::DEFAULT_FORMAT;
        }

        if (!array_key_exists('format', $arguments)) {
            return self::DEFAULT_FORMAT;
        }

        return $arguments['format'];
    }
}