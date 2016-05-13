<?php

namespace Anthill\Phalcon\AnnotationSerializer\Serializer;


use Anthill\Phalcon\AnnotationSerializer\Normalizers\Getter\GetterGroupNormalizeStructure;
use Anthill\Phalcon\AnnotationSerializer\Normalizers\Getter\GetterStructure;
use Anthill\Phalcon\AnnotationSerializer\Serializer\Exceptions\SerializeException;
use Anthill\Phalcon\AnnotationSerializer\Structures\Field;

class JsonSerializer implements SerializeInterface
{

    /**
     * @var GetterStructure
     */
    private $structure;

    public function __construct(GetterStructure $structure)
    {
        $this->structure = $structure;
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

        $result = $this->doSerialize($object, $fields);

        if (!$result) {
            // we want to send object if result is empty
            return '{}';
        }
        return json_encode($result);
    }


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
        $closure = function ($field) use ($structure) {
            $getter = $structure->getGetterByField($field);
            $field = $getter->getField();
            $fieldName = $field->getName();
            if ($field->getType() === Field::TYPE_METHOD) {
                if (!method_exists($this, $fieldName)) {
                    return null;
                }
                return $this->{$fieldName}();
            }

            if ($field->getType() === Field::TYPE_PROPERTY) {
                if (!property_exists($this, $fieldName)) {
                    return null;
                }
                return $this->{$fieldName};
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