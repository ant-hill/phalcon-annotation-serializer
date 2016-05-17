<?php

namespace Anthill\Phalcon\AnnotationSerializer\Deserializer;


use Anthill\Phalcon\AnnotationSerializer\Deserializer\Exceptions\DeserializeException;
use Anthill\Phalcon\AnnotationSerializer\Normalizers\Getter\GetterGroupNormalizeStructure;
use Anthill\Phalcon\AnnotationSerializer\Normalizers\Setter\SetterStructure;
use Anthill\Phalcon\AnnotationSerializer\Structures\Field;
use Anthill\Phalcon\AnnotationSerializer\Types\TypeManager;

class ArrayDeserializer implements DeserializeInterface
{

    /**
     * @var SetterStructure
     */
    private $structure;
    /**
     * @var TypeManager
     */
    private $converterManager;

    public function __construct(SetterStructure $structure, TypeManager $typeManager)
    {
        $this->structure = $structure;
        $this->converterManager = $typeManager;
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
     * @param array $data
     * @param array $fields
     * @return array
     */
    private function doDeserialize($object, array $data, array $fields)
    {
        $entity = clone $object;
        $structure = $this->structure;
        $converterManager = $this->converterManager;
        $closure = function ($field, $value) use ($structure,$converterManager) {
            $setter = $structure->getSetterByField($field);

            $converterType = $setter->getType();
            if($converterType && $converterManager->has($converterType)){
                $value = $converterManager->from($converterType,$value,$setter->getTypeArguments());
            }
            
            $field = $setter->getField();
            $fieldName = $field->getName();
            if ($field->getType() === Field::TYPE_METHOD) {
                if (!method_exists($this, $fieldName)) {
                    return;
                }
                $this->{$fieldName}($value);
            } elseif ($field->getType() === Field::TYPE_PROPERTY) {
                if (!property_exists($this, $fieldName)) {
                    return;
                }
                $this->{$fieldName} = $value;
            }
        };
        $closure = $closure->bindTo($entity, $entity);

        foreach ($fields as $field) {
            if (!array_key_exists($field, $data)) {
                continue;
            }
            $closure($field, $data[$field]);
        }
        return $entity;
    }

    /**
     * @param $object
     * @param array $data
     * @param array $groups
     * @return mixed
     * @throws DeserializeException
     */
    public function deserialize($object, array $data, array $groups = array())
    {
        if (!is_object($object)) {
            throw new DeserializeException('First parameter must be an object');
        }
        if (!$groups) {
            $fields = $this->getFields();
        } else {
            $fields = $this->getGroupsFields($groups);
        }

        $result = $this->doDeserialize($object, $data, $fields);
        return $result;

    }
}