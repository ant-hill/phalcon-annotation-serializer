<?php
namespace Tests\Anthill\Phalcon\AnnotationSerializer;

use Anthill\Phalcon\AnnotationSerializer\AnnotationProcessor;
use Anthill\Phalcon\AnnotationSerializer\Deserializer\ArrayDeserializer;
use Anthill\Phalcon\AnnotationSerializer\Normalizers\NormalizeGetter;
use Anthill\Phalcon\AnnotationSerializer\Normalizers\NormalizerManager;
use Anthill\Phalcon\AnnotationSerializer\Normalizers\NormalizeSetter;
use Anthill\Phalcon\AnnotationSerializer\SerializeManager;
use Anthill\Phalcon\AnnotationSerializer\Serializer\ArraySerializer;
use Anthill\Phalcon\AnnotationSerializer\Serializer\JsonSerializer;
use Anthill\Phalcon\AnnotationSerializer\Types\Converters\BooleanConverter;
use Anthill\Phalcon\AnnotationSerializer\Types\Converters\DateTimeConverter;
use Anthill\Phalcon\AnnotationSerializer\Types\Converters\IntegerConverter;
use Anthill\Phalcon\AnnotationSerializer\Types\Converters\StringConverter;
use Anthill\Phalcon\AnnotationSerializer\Types\TypeManager;
use Phalcon\Annotations\Adapter\Memory as MemoryAnnotationAdapter;
use Tests\Anthill\Phalcon\AnnotationSerializer\Fixtures\SomeEntityFixture;
use Tests\Anthill\Phalcon\AnnotationSerializer\Fixtures\SomeEntityFixture2;

class ComplexTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @return SerializeManager
     */
    private function getJsonManager()
    {
        $annotationProcessor = new AnnotationProcessor(new MemoryAnnotationAdapter());
        $normalizeGetter = new NormalizeGetter();
        $normalizeSetter = new NormalizeSetter();
        $normalizerManager = new NormalizerManager($normalizeGetter, $normalizeSetter);
        return new SerializeManager($annotationProcessor, $normalizerManager, JsonSerializer::class,
            ArrayDeserializer::class, new TypeManager(
                [
                    'string' => new StringConverter(),
                    'int' => new IntegerConverter(),
                    'integer' => new IntegerConverter(),
                    'boolean' => new BooleanConverter(),
                    'dateTime' => new DateTimeConverter(),
                ])
        );
    }

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
                    'dateTime' => new DateTimeConverter(),
                ])
        );
    }


    public function testSerializerWithoutGroups1()
    {
        $manager = $this->getJsonManager();
        $object = new SomeEntityFixture2();
        $json = $manager->serialize($object);
        $expectedJson = '{"field_a":null,"field_b":null,"fieldD":null,"field_e":null,"some_fields":"pew-pew"}';
        $this->assertJson($json);
        $this->assertJsonStringEqualsJsonString($expectedJson, $json);
    }

    public function testSerializeArray()
    {
        $manager = $this->getArrayManager();
        $object = new SomeEntityFixture2();
        $testArray = [];
        $testArray[] = clone $object;
        $testArray[] = clone $object;
        $testArray[] = clone $object;
        $expected = [
            ['field_a' => null, 'field_b' => null, 'fieldD' => null, 'field_e' => null, 'some_fields' => 'pew-pew'],
            ['field_a' => null, 'field_b' => null, 'fieldD' => null, 'field_e' => null, 'some_fields' => 'pew-pew'],
            ['field_a' => null, 'field_b' => null, 'fieldD' => null, 'field_e' => null, 'some_fields' => 'pew-pew'],
        ];
        $this->assertEquals($expected, $manager->serialize($testArray));

    }

    public function testSerializeArray2()
    {
        $manager = $this->getArrayManager();
        $object = new SomeEntityFixture2();
        $testArray = [];
        $testArray[] = [clone $object];
        $testArray[] = ['z' => clone $object];
        $testArray[] = [clone $object];
        $testArray[] = clone $object;
        $testArray[] = clone $object;
        $expected = [
            [['field_a' => null, 'field_b' => null, 'fieldD' => null, 'field_e' => null, 'some_fields' => 'pew-pew']],
            ['z' =>
                ['field_a' => null,'field_b' => null,'fieldD' => null,'field_e' => null,'some_fields' => 'pew-pew']
            ],
            [['field_a' => null, 'field_b' => null, 'fieldD' => null, 'field_e' => null, 'some_fields' => 'pew-pew']],
            ['field_a' => null, 'field_b' => null, 'fieldD' => null, 'field_e' => null, 'some_fields' => 'pew-pew'],
            ['field_a' => null, 'field_b' => null, 'fieldD' => null, 'field_e' => null, 'some_fields' => 'pew-pew'],
        ];
        $this->assertEquals($expected, $manager->serialize($testArray));

    }

    public function testSerializerWithoutGroups2()
    {
        $manager = $this->getJsonManager();
        $object = new SomeEntityFixture2();
        $object->setFieldA('qwe');
        $object->setFieldB('asd');
        $object->setFieldD(1);
        $object->setFieldE('aaa');
        $json = $manager->serialize($object);

        $expectedJson = '{"field_a":"qwe","field_b":"asd","fieldD":1,"field_e":"aaa","some_fields":"pew-pew"}';
        $this->assertJson($json);
        $this->assertJsonStringEqualsJsonString($expectedJson, $json);
    }

    public function testSerializerWithGroups()
    {
        $manager = $this->getJsonManager();

        $object = new SomeEntityFixture2();
        $json = $manager->serialize($object, array('groupA'));
        $expectedJson = '{"field_a":null,"field_b":null}';
        $this->assertJson($json);
        $this->assertJsonStringEqualsJsonString($expectedJson, $json);

        $object = new SomeEntityFixture2();
        $object->setFieldA('qwe');
        $object->setFieldB('azx');
        $json = $manager->serialize($object, array('groupA'));
        $expectedJson = '{"field_a":"qwe","field_b":"azx"}';
        $this->assertJson($json);
        $this->assertJsonStringEqualsJsonString($expectedJson, $json);

        $object = new SomeEntityFixture2();
        $json = $manager->serialize($object, array('groupB'));
        $expectedJson = '{"field_a":null,"field_e":null}';
        $this->assertJson($json);
        $this->assertJsonStringEqualsJsonString($expectedJson, $json);

        $object = new SomeEntityFixture2();
        $object->setFieldA('zzz');
        $object->setFieldE('eee');
        $json = $manager->serialize($object, array('groupB'));
        $expectedJson = '{"field_a":"zzz","field_e":"eee"}';
        $this->assertJson($json);
        $this->assertJsonStringEqualsJsonString($expectedJson, $json);

        $object = new SomeEntityFixture2();
        $json = $manager->serialize($object, array('groupA', 'groupB'));
        $expectedJson = '{"field_a":null,"field_b":null,"field_e":null}';
        $this->assertJson($json);
        $this->assertJsonStringEqualsJsonString($expectedJson, $json);

        $object = new SomeEntityFixture2();
        $json = $manager->serialize($object, array('groupA', 'groupE'));
        $expectedJson = '{"field_a":null,"field_b":null}';
        $this->assertJson($json);
        $this->assertJsonStringEqualsJsonString($expectedJson, $json);

        $object = new SomeEntityFixture2();
        $json = $manager->serialize($object, array('groupE'));
        $expectedJson = '{}';
        $this->assertJson($json);
        $this->assertJsonStringEqualsJsonString($expectedJson, $json);
    }


    public function testSerializerWithNotAnnotatedObject()
    {
        $manager = $this->getJsonManager();

        $object = new SomeEntityFixture();
        $json = $manager->serialize($object);
        $expectedJson = '{}';
        $this->assertJson($json);
        $this->assertJsonStringEqualsJsonString($expectedJson, $json);

        $object = new SomeEntityFixture();
        $json = $manager->serialize($object, array('groupA'));
        $expectedJson = '{}';
        $this->assertJson($json);
        $this->assertJsonStringEqualsJsonString($expectedJson, $json);

    }

    public function testDeserializationWithoutGroups()
    {
        $manager = $this->getArrayManager();

        $object = new SomeEntityFixture2();

        $data = array(
            'field_a' => 'value_a',
            'field_b' => 'value_b',
            'field_c' => 'value_c',
            'fieldD' => 'value_d',
            'field_asdasd' => 111,
            'field_e' => 'value_e',
        );

        $deserializedObject = $manager->deserialize($object, $data);
        $expectedObject = new SomeEntityFixture2();
        $expectedObject->setFieldA('value_a');
        $expectedObject->setFieldC('value_c');
        $expectedObject->setFieldD('value_d');
        $expectedObject->setFieldE('value_e');
        $this->assertEquals($expectedObject, $deserializedObject);
    }

    public function testDeserializationWithNotExistedGroups()
    {
        $manager = $this->getArrayManager();

        $object = new SomeEntityFixture2();

        $data = array(
            'field_a' => 'value_a',
            'field_b' => 'value_b',
            'field_c' => 'value_c',
            'fieldD' => 'value_d',
            'field_asdasd' => 111,
            'field_e' => 'value_e',
        );

        $deserializedObject = $manager->deserialize($object, $data, array('ololo'));
        $expectedObject = new SomeEntityFixture2();
        $this->assertEquals($expectedObject, $deserializedObject);
    }

    public function testDeserializationWithGroups()
    {
        $manager = $this->getArrayManager();

        $object = new SomeEntityFixture2();

        $data = array(
            'field_a' => 'value_a',
            'field_b' => 'value_b',
            'field_c' => 'value_c',
            'fieldD' => 'value_d',
            'field_asdasd' => 111,
            'field_e' => 'value_e',
        );

        $deserializedObject = $manager->deserialize($object, $data, array('groupA'));
        $expectedObject = new SomeEntityFixture2();
        $expectedObject->setFieldA('value_a');
        $expectedObject->setFieldC('value_c');
        $this->assertEquals($expectedObject, $deserializedObject);
    }

    public function testDeserializationWithGroups2()
    {
        $manager = $this->getArrayManager();

        $object = new SomeEntityFixture2();

        $data = array(
            'field_a' => 'value_a',
            'field_b' => 'value_b',
            'field_c' => 'value_c',
            'fieldD' => 'value_d',
            'field_asdasd' => 111,
            'field_e' => 'value_e',
        );

        $deserializedObject = $manager->deserialize($object, $data, array('groupB'));
        $expectedObject = new SomeEntityFixture2();
        $expectedObject->setFieldA('value_a');
        $expectedObject->setFieldE('value_e');
        $this->assertEquals($expectedObject, $deserializedObject);
    }

    public function testDeserializationWithGroups3()
    {
        $manager = $this->getArrayManager();

        $object = new SomeEntityFixture2();

        $data = array(
            'field_a' => 'value_a',
            'field_b' => 'value_b',
            'field_c' => 'value_c',
            'fieldD' => 'value_d',
            'field_asdasd' => 111,
            'field_e' => 'value_e',
        );

        $deserializedObject = $manager->deserialize($object, $data, array('groupA', 'groupB'));
        $expectedObject = new SomeEntityFixture2();
        $expectedObject->setFieldA('value_a');
        $expectedObject->setFieldC('value_c');
        $expectedObject->setFieldE('value_e');
        $this->assertEquals($expectedObject, $deserializedObject);
    }

}