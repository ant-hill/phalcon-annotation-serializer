<?php

namespace Tests\Anthill\Phalcon\AnnotationSerializer\Fixtures;

/**
 * Class SomeEntityFixture2
 * @package Tests\Anthill\Phalcon\AnnotationSerializer\Fixtures
 *
 */
class SomeEntityFixture2
{

    /**
     * @Property(name="field_a",groups={"groupA","groupB"},setter="setFieldA",getter="getFieldA")
     */
    private $fieldA;

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
     * @Serialize(name="field_b",groups="groupA")
     */
    private $fieldB;

    /**
     * @Deserialize(name="field_c",groups="groupA")
     * @var string
     */
    private $fieldC = 'valueC';

    /**
     * @Serialize()
     * @Deserialize()
     * @var string
     */
    private $fieldD;

    /**
     * @Property(name="field_e",groups="groupB")
     * @var string
     */
    private $fieldE;

    /**
     * @VirtualPropertySerialize(name="some_fields")
     * @return string
     */
    public function getSomeFields()
    {
        return 'pew-pew';
    }

    public function toArray()
    {
        return array(
            'fieldA' => $this->fieldA,
            'fieldB' => $this->fieldB,
            'fieldC' => $this->fieldC,
            'fieldD' => $this->fieldD,
        );
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

    /**
     * @return string
     */
    public function getFieldE()
    {
        return $this->fieldE;
    }

    /**
     * @param string $fieldE
     */
    public function setFieldE($fieldE)
    {
        $this->fieldE = $fieldE;
    }
}