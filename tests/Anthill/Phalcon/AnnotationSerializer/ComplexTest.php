<?php
namespace Tests\Anthill\Phalcon\AnnotationSerializer;

use Anthill\Phalcon\AnnotationSerializer\AnnotationProcessor;
use Anthill\Phalcon\AnnotationSerializer\Normalizers\NormalizeGetter;
use Anthill\Phalcon\AnnotationSerializer\Normalizers\NormalizerManager;
use Anthill\Phalcon\AnnotationSerializer\Normalizers\NormalizeSetter;
use Anthill\Phalcon\AnnotationSerializer\SerializeManager;
use Phalcon\Annotations\Adapter\Memory as MemoryAnnotationAdapter;
use Tests\Anthill\Phalcon\AnnotationSerializer\Fixtures\SomeEntityFixture;
use Tests\Anthill\Phalcon\AnnotationSerializer\Fixtures\SomeEntityFixture2;

class ComplexTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @return SerializeManager
     */
    private function getManager()
    {
        $annotationProcessor = new AnnotationProcessor(new MemoryAnnotationAdapter());
        $normalizeGetter = new NormalizeGetter();
        $normalizeSetter = new NormalizeSetter();
        $normalizerManager = new NormalizerManager($normalizeGetter, $normalizeSetter);
        return new SerializeManager($annotationProcessor, $normalizerManager);
    }


    public function testSerializerWithoutGroups1()
    {
        $manager = $this->getManager();
        $object = new SomeEntityFixture2();
        $json = $manager->serialize($object);
        $expectedJson = '{"field_a":null,"field_b":null,"fieldD":null,"field_e":null,"some_fields":"pew-pew"}';
        $this->assertJson($json);
        $this->assertJsonStringEqualsJsonString($expectedJson, $json);
    }

    public function testSerializerWithoutGroups2()
    {
        $manager = $this->getManager();
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
        $manager = $this->getManager();

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
        $manager = $this->getManager();

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
        $manager = $this->getManager();

        $object = new SomeEntityFixture2();

        $data = array(
            'field_a' => 'value_a',
            'field_b' => 'value_b',
            'field_c' => 'value_c',
            'fieldD' => 'value_d',
            'field_asdasd' => 111,
            'field_e' => 'value_e',
        );

        $deserializedObject = $manager->deserialize($object,$data);
        $expectedObject = new SomeEntityFixture2();
        $expectedObject->setFieldA('value_a');
        $expectedObject->setFieldC('value_c');
        $expectedObject->setFieldD('value_d');
        $expectedObject->setFieldE('value_e');
        $this->assertEquals($expectedObject,$deserializedObject);
    }

    public function testDeserializationWithNotExistedGroups()
    {
        $manager = $this->getManager();

        $object = new SomeEntityFixture2();

        $data = array(
            'field_a' => 'value_a',
            'field_b' => 'value_b',
            'field_c' => 'value_c',
            'fieldD' => 'value_d',
            'field_asdasd' => 111,
            'field_e' => 'value_e',
        );

        $deserializedObject = $manager->deserialize($object,$data,array('ololo'));
        $expectedObject = new SomeEntityFixture2();
        $this->assertEquals($expectedObject,$deserializedObject);
    }

    public function testDeserializationWithGroups()
    {
        $manager = $this->getManager();

        $object = new SomeEntityFixture2();

        $data = array(
            'field_a' => 'value_a',
            'field_b' => 'value_b',
            'field_c' => 'value_c',
            'fieldD' => 'value_d',
            'field_asdasd' => 111,
            'field_e' => 'value_e',
        );

        $deserializedObject = $manager->deserialize($object,$data,array('groupA'));
        $expectedObject = new SomeEntityFixture2();
        $expectedObject->setFieldA('value_a');
        $expectedObject->setFieldC('value_c');
        $this->assertEquals($expectedObject,$deserializedObject);
    }

    public function testDeserializationWithGroups2()
    {
        $manager = $this->getManager();

        $object = new SomeEntityFixture2();

        $data = array(
            'field_a' => 'value_a',
            'field_b' => 'value_b',
            'field_c' => 'value_c',
            'fieldD' => 'value_d',
            'field_asdasd' => 111,
            'field_e' => 'value_e',
        );

        $deserializedObject = $manager->deserialize($object,$data,array('groupB'));
        $expectedObject = new SomeEntityFixture2();
        $expectedObject->setFieldA('value_a');
        $expectedObject->setFieldE('value_e');
        $this->assertEquals($expectedObject,$deserializedObject);
    }

    public function testDeserializationWithGroups3()
    {
        $manager = $this->getManager();

        $object = new SomeEntityFixture2();

        $data = array(
            'field_a' => 'value_a',
            'field_b' => 'value_b',
            'field_c' => 'value_c',
            'fieldD' => 'value_d',
            'field_asdasd' => 111,
            'field_e' => 'value_e',
        );

        $deserializedObject = $manager->deserialize($object,$data,array('groupA','groupB'));
        $expectedObject = new SomeEntityFixture2();
        $expectedObject->setFieldA('value_a');
        $expectedObject->setFieldC('value_c');
        $expectedObject->setFieldE('value_e');
        $this->assertEquals($expectedObject,$deserializedObject);
    }

}