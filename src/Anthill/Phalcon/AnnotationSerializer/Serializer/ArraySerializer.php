<?php

namespace Anthill\Phalcon\AnnotationSerializer\Serializer;


use Anthill\Phalcon\AnnotationSerializer\Normalizers\Getter\GetterGroupNormalizeStructure;
use Anthill\Phalcon\AnnotationSerializer\Normalizers\Getter\GetterStructure;
use Anthill\Phalcon\AnnotationSerializer\Serializer\Exceptions\SerializeException;
use Anthill\Phalcon\AnnotationSerializer\Structures\Field;
use Anthill\Phalcon\AnnotationSerializer\Types\TypeManager;

class ArraySerializer implements SerializeInterface
{

    /**
     * @var GetterStructure
     */
    private $structure;
    /**
     * @var TypeManager
     */
    private $converterManager;

    public function __construct(GetterStructure $structure, TypeManager $typeManager)
    {
        $this->structure = $structure;
        $this->converterManager = $typeManager;
    }

    /**
     * @param $object
     * @param array $groups
     * @return mixed
     * @throws \Anthill\Phalcon\AnnotationSerializer\Serializer\Exceptions\SerializeException
     */
    public function serialize($object, array $groups = array())
    {
        if (!is_object($object)) {
            throw new SerializeException('First parameter must be an object');
        }
        if (!$groups) {
            $fields = $this->getFields();
        } else {
            $fields = $this->getGroupsFields($groups);
        }

        return $this->doSerialize($object, $fields);
    }

    /**
     * @param array $groups
     * @return mixed
     */
    private function getGroupsFields(array $groups = array())
    {
        $groupMerge = new GetterGroupNormalizeStructure();
        foreach ($groups as $group) {
            if (!$this->structure->groupExists($group)) {
                continue;
            }
            foreach ($this->structure->getGroup($group)->getFields() as $groupField) {
                $groupMerge->addField($groupField);
            }
        }
        return $groupMerge->getFields();
    }

    /**
     * @return array
     */
    private function getFields()
    {
        return $this->structure->getGettersFields();
    }

    /**
     * @param $object
     * @param array $fields
     * @return array
     */
    private function doSerialize($object, array $fields)
    {
        $structure = $this->structure;
        $converterManager = $this->converterManager;
        $closure = function ($field) use ($structure, $converterManager) {
            $getter = $structure->getGetterByField($field);
            $field = $getter->getField();
            $fieldName = $field->getName();

            $converterType = $getter->getType();
            $needConvert = false;
            if ($converterType && $converterManager->has($converterType)) {
                $needConvert = true;
            }

            if ($field->getType() === Field::TYPE_METHOD) {
                if (!method_exists($this, $fieldName)) {
                    return null;
                }

                $value = $this->{$fieldName}();
                if ($needConvert) {
                    $value = $converterManager->to($converterType, $value, $getter->getTypeArguments());
                }
                return $value;
            }

            if ($field->getType() === Field::TYPE_PROPERTY) {
                if (!property_exists($this, $fieldName)) {
                    return null;
                }
                $value = $this->{$fieldName};
                if ($needConvert) {
                    $value = $converterManager->to($converterType, $value, $getter->getTypeArguments());
                }
                return $value;
            }
            return null;
        };
        $closure = $closure->bindTo($object, $object);

        $resultArray = array();
        foreach ($fields as $field) {
            $resultArray[$field] = $closure($field);
        }
        return $resultArray;
    }
}