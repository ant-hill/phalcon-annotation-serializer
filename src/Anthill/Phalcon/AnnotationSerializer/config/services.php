<?php

return array(
    'annotations' => array(
        'className' => \Phalcon\Annotations\Adapter\Memory::class,
        'shared' => true
    ),
    'filter' => array(
        'className' => \Phalcon\Filter::class,
    ),
    'anthill.annotation_processor' => array(
        'className' => \Anthill\Phalcon\AnnotationSerializer\AnnotationProcessor::class,
        'arguments' => array(
            array(
                'type' => 'service',
                'name' => 'annotations'
            )
        )
    ),
    'anthill.getter_normalizer_default' => array(
        'className' => \Anthill\Phalcon\AnnotationSerializer\Normalizers\NormalizeGetter::class
    ),
    'anthill.setter_normalizer_default' => array(
        'className' => \Anthill\Phalcon\AnnotationSerializer\Normalizers\NormalizeSetter::class
    ),
    'anthill.normalizer_manager' => array(
        'className' => \Anthill\Phalcon\AnnotationSerializer\Normalizers\NormalizerManager::class,
        'arguments' => array(
            array(
                'type' => 'service',
                'name' => 'anthill.getter_normalizer_default'
            ),
            array(
                'type' => 'service',
                'name' => 'anthill.setter_normalizer_default'
            ),
        )
    ),
    'anthill.type_manager' => array(
        'className' => \Anthill\Phalcon\AnnotationSerializer\Types\TypeManager::class,
        'calls' => array(
            array(
                'method' => 'set',
                'arguments' => array(
                    array(
                        'type' => 'parameter',
                        'value' => 'string'
                    ),
                    array(
                        'type' => 'instance',
                        'className' => \Anthill\Phalcon\AnnotationSerializer\Types\Converters\StringConverter::class
                    ),
                )
            ),
            array(
                'method' => 'set',
                'arguments' => array(
                    array(
                        'type' => 'parameter',
                        'value' => 'int'
                    ),
                    array(
                        'type' => 'instance',
                        'className' => \Anthill\Phalcon\AnnotationSerializer\Types\Converters\IntegerConverter::class
                    ),
                )
            ),
            array(
                'method' => 'set',
                'arguments' => array(
                    array(
                        'type' => 'parameter',
                        'value' => 'integer'
                    ),
                    array(
                        'type' => 'instance',
                        'className' => \Anthill\Phalcon\AnnotationSerializer\Types\Converters\IntegerConverter::class
                    ),
                )
            ),
            array(
                'method' => 'set',
                'arguments' => array(
                    array(
                        'type' => 'parameter',
                        'value' => 'boolean'
                    ),
                    array(
                        'type' => 'instance',
                        'className' => \Anthill\Phalcon\AnnotationSerializer\Types\Converters\BooleanConverter::class
                    ),
                )
            ),
            array(
                'method' => 'set',
                'arguments' => array(
                    array(
                        'type' => 'parameter',
                        'value' => 'bool'
                    ),
                    array(
                        'type' => 'instance',
                        'className' => \Anthill\Phalcon\AnnotationSerializer\Types\Converters\BooleanConverter::class
                    ),
                )
            ),
            array(
                'method' => 'set',
                'arguments' => array(
                    array(
                        'type' => 'parameter',
                        'value' => 'datetime'
                    ),
                    array(
                        'type' => 'instance',
                        'className' => \Anthill\Phalcon\AnnotationSerializer\Types\Converters\DateTimeConverter::class
                    ),
                )
            ),
        ),
        'shared' => true
    ),
    'anthill.serialize_manager' => array(
        'className' => \Anthill\Phalcon\AnnotationSerializer\SerializeManager::class,
        'arguments' => array(
            array(
                'type' => 'service',
                'name' => 'anthill.annotation_processor'
            ),
            array(
                'type' => 'service',
                'name' => 'anthill.normalizer_manager'
            ),
            array(
                'type' => 'parameter',
                'value' => \Anthill\Phalcon\AnnotationSerializer\Serializer\ArraySerializer::class,
            ),
            array(
                'type' => 'parameter',
                'value' => \Anthill\Phalcon\AnnotationSerializer\Deserializer\ArrayDeserializer::class,
            ),
            array(
                'type' => 'service',
                'name' => 'anthill.type_manager'
            ),
        )
    )
);