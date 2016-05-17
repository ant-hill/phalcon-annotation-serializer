<?php
namespace Tests\Anthill\Phalcon\AnnotationSerializer;

use Anthill\Phalcon\AnnotationSerializer\AnnotationProcessor;
use Anthill\Phalcon\AnnotationSerializer\Deserializer\ArrayDeserializer;
use Anthill\Phalcon\AnnotationSerializer\Normalizers\NormalizeGetter;
use Anthill\Phalcon\AnnotationSerializer\Normalizers\NormalizerManager;
use Anthill\Phalcon\AnnotationSerializer\Normalizers\NormalizeSetter;
use Anthill\Phalcon\AnnotationSerializer\SerializeManager;
use Anthill\Phalcon\AnnotationSerializer\Serializer\ArraySerializer;
use Anthill\Phalcon\AnnotationSerializer\Types\Converters\BooleanConverter;
use Anthill\Phalcon\AnnotationSerializer\Types\Converters\DateTimeConverter;
use Anthill\Phalcon\AnnotationSerializer\Types\Converters\IntegerConverter;
use Anthill\Phalcon\AnnotationSerializer\Types\Converters\StringConverter;
use Anthill\Phalcon\AnnotationSerializer\Types\TypeManager;
use Phalcon\Annotations\Adapter\Memory as MemoryAnnotationAdapter;
use Tests\Anthill\Phalcon\AnnotationSerializer\Fixtures\ConverterEntityFixture;

class ConverterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @return SerializeManager
     */
    private function getArrayManager()
    {
        $annotationProcessor = new AnnotationProcessor(new MemoryAnnotationAdapter());
        $normalizeGetter = new NormalizeGetter();
        $normalizeSetter = new NormalizeSetter();
        $normalizerManager = new NormalizerManager($normalizeGetter, $normalizeSetter);
        return new SerializeManager($annotationProcessor, $normalizerManager, ArraySerializer::class,
            ArrayDeserializer::class, new TypeManager(
                [
                    'string' => new StringConverter(),
                    'int' => new IntegerConverter(),
                    'integer' => new IntegerConverter(),
                    'boolean' => new BooleanConverter(),
                    'bool' => new BooleanConverter(),
                    'dateTime' => new DateTimeConverter(),
                ])
        );
    }


    public function testSerializer()
    {
        $manager = $this->getArrayManager();
        $entity = new ConverterEntityFixture();
        $result = $manager->serialize($entity);
        $expected = array(
            'field_a' => 'valueA',
            'field_b' => '123',
            'field_d' => null,
            'some_fields' => true

        );
        $this->assertEquals($expected, $result);
    }

    public function testSerializer2()
    {
        $manager = $this->getArrayManager();
        $entity = new ConverterEntityFixture();
        $dateTime = new \DateTime();
        $entity->setFieldD($dateTime);
        $result = $manager->serialize($entity);
        $expected = array(
            'field_a' => 'valueA',
            'field_b' => '123',
            'field_d' => $dateTime->format('Y-m-d h:i:s'),
            'some_fields' => true

        );
        $this->assertEquals($expected, $result);
    }

    public function testDeserializer()
    {
        $manager = $this->getArrayManager();
        $entity = new ConverterEntityFixture();
        $fromArray = array(
            'field_a' => 123,
            'field_c' => '123'
        );

        $result = $manager->deserialize($entity,$fromArray);
        $expected = clone $entity;
        $expected->setFieldA("123");
        $expected->setFieldC(null);
        $this->assertEquals($expected, $result);
        $this->assertSame($expected->getFieldA(), $result->getFieldA());
    }

    public function testDeserializer2()
    {
        $manager = $this->getArrayManager();
        $entity = new ConverterEntityFixture();
        $dateTime = new \DateTime();
        $dateTimeString = $dateTime->format('Y-m-d h:i:s');

        $fromArray = array(
            'field_a' => 123,
            'field_c' => $dateTimeString
        );

        $result = $manager->deserialize($entity,$fromArray);
        $expected = clone $entity;
        $expected->setFieldA("123");
        $expected->setFieldC($dateTime);
        $this->assertEquals($expected, $result);
    }

}