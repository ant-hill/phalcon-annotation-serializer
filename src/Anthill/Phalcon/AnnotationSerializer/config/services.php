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
        )
    )
);