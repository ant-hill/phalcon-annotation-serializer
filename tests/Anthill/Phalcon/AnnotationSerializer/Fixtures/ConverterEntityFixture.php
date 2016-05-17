<?php

namespace Tests\Anthill\Phalcon\AnnotationSerializer\Fixtures;

/**
 * Class SomeEntityFixture2
 * @package Tests\Anthill\Phalcon\AnnotationSerializer\Fixtures
 *
 */
class ConverterEntityFixture
{

    /**
     * @Property(name="field_a",setter="setFieldA",getter="getFieldA",type="string")
     */
    private $fieldA = "valueA";

    /**
     * @return mixed
     */
    public function getFieldA()
    {
        return $this->fieldA;
    }

    /**
     * @param mixed $fieldA
     */
    public function setFieldA($fieldA)
    {
        $this->fieldA = $fieldA;
    }

    /**
     * @Serialize(name="field_b",type="string")
     */
    private $fieldB = 123;

    /**
     * @Deserialize(name="field_c",type="dateTime",type_arguments={format="Y-m-d h:i:s"})
     * @var string
     */
    private $fieldC = null;

    /**
     * @Serialize(name="field_d",type="dateTime",type_arguments={format="Y-m-d h:i:s"})
     * @var string
     */
    private $fieldD = null;

    /**
     * @VirtualPropertySerialize(name="some_fields",type="bool")
     * @return string
     */
    public function getSomeFields()
    {
        return 'pew-pew';
    }

    /**
     * @return mixed
     */
    public function getFieldB()
    {
        return $this->fieldB;
    }

    /**
     * @param mixed $fieldB
     */
    public function setFieldB($fieldB)
    {
        $this->fieldB = $fieldB;
    }

    /**
     * @return string
     */
    public function getFieldC()
    {
        return $this->fieldC;
    }

    /**
     * @param string $fieldC
     */
    public function setFieldC($fieldC)
    {
        $this->fieldC = $fieldC;
    }

    /**
     * @return string
     */
    public function getFieldD()
    {
        return $this->fieldD;
    }

    /**
     * @param string $fieldD
     */
    public function setFieldD($fieldD)
    {
        $this->fieldD = $fieldD;
    }
}