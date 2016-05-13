<?php

namespace Tests\Anthill\Phalcon\AnnotationSerializer\Fixtures;

class SomeEntityFixture
{
    /**
     * @var
     */
    private $fieldA;
    /**
     * @var
     */
    private $fieldB;

    /**
     * @var
     */
    private $fieldC = 'pewpew';

    public function toArray(){
        return get_object_vars($this);
    }

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
     * @return mixed
     */
    public function getFieldC()
    {
        return $this->fieldC;
    }

    /**
     * @param mixed $fieldC
     */
    public function setFieldC($fieldC)
    {
        $this->fieldC = $fieldC;
    }
}