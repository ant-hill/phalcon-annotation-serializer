<?php

namespace Anthill\Phalcon\AnnotationSerializer;

use Anthill\Phalcon\AnnotationSerializer\Deserializer\DeserializeInterface;
use Anthill\Phalcon\AnnotationSerializer\Serializer\SerializeInterface;

interface SerializeManagerInterface extends SerializeInterface,DeserializeInterface
{
}