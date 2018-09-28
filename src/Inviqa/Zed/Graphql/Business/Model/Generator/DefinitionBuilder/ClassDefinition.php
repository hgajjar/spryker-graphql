<?php

namespace Inviqa\Zed\Graphql\Business\Model\Generator\DefinitionBuilder;

use Inviqa\Zed\Graphql\Business\Model\Generator\DefinitionInterface;
use Spryker\Zed\Transfer\Business\Exception\InvalidNameException;
use Zend\Filter\Word\CamelCaseToUnderscore;
use Zend\Filter\Word\UnderscoreToCamelCase;

class ClassDefinition implements ClassDefinitionInterface
{
    const TYPE_FULLY_QUALIFIED = 'type_fully_qualified';

    /**
     * @var string
     */
    private $name;

    /**
     * @var array
     */
    private $constructorDefinition = [];

    /**
     * @param array $definition
     *
     * @return $this
     */
    public function setDefinition(array $definition): DefinitionInterface
    {
        $this->setName($definition['name']);

        if (isset($definition['property'])) {
            $this->addConstructorDefinition($definition);
        }

        return $this;
    }

    /**
     * @param string $name
     *
     * @return $this
     */
    private function setName($name)
    {
        if (strpos($name, 'Type') === false) {
            $name .= 'Type';
        }
        $this->name = ucfirst($name);

        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return array
     */
    public function getConstructorDefinition()
    {
        return $this->constructorDefinition;
    }

    /**
     * @param array $property
     *
     * @return string
     */
    private function getPropertyName(array $property)
    {
        $filter = new UnderscoreToCamelCase();

        return lcfirst($filter->filter($property['name']));
    }

    private function addConstructorDefinition(array $definition)
    {
        $properties = $this->normalizePropertyTypes($definition['property']);
        $fields = [];
        foreach ($properties as $property) {
            $fields[$this->getPropertyName($property)] = [
                'type' => $property['type']
            ];
        }

        $config = [
            'name' => $definition['name'],
            'description' => $definition['name'],
            'fields' => $fields,
        ];

        $this->constructorDefinition = $config;
    }

    /**
     * Properties which are Transfer MUST be suffixed with Transfer
     *
     * @param array $properties
     *
     * @return array
     */
    private function normalizePropertyTypes(array $properties)
    {
        $normalizedProperties = [];
        foreach ($properties as $property) {
            $this->assertProperty($property);

            $property[self::TYPE_FULLY_QUALIFIED] = $property['type'];
            $property['is_collection'] = false;
            $property['is_transfer'] = false;
            $property['propertyConst'] = $this->getPropertyConstantName($property);
            $property['name_underscore'] = mb_strtolower($property['propertyConst']);

            if ($this->isTypedArray($property)) {
                $type = preg_replace('/\[\]/', '', $property['type']);
                $property['type'] = 'Type::listOf('.$this->getSchemaType($type).')';
            } elseif ($this->isTypeOrTypeArray($property['type'])) {
                $property = $this->buildTypePropertyDefinition($property);
            } elseif ($this->isArray($property)) {
                $property['type'] = 'Type::listOf(Type::string())';
            } else {
                $property['type'] = $this->getSchemaType($property['type']);
            }

            $normalizedProperties[] = $property;
        }

        return $normalizedProperties;
    }

    /**
     * @param array $property
     *
     * @return void
     */
    private function assertProperty(array $property)
    {
        $this->assertPropertyName($property['name']);
    }

    /**
     * @param string $propertyName
     *
     * @throws \Spryker\Zed\Transfer\Business\Exception\InvalidNameException
     *
     * @return void
     */
    private function assertPropertyName($propertyName)
    {
        if (!preg_match('/^[a-zA-Z][a-zA-Z0-9]+$/', $propertyName)) {
            throw new InvalidNameException(sprintf(
                'Transfer property "%s" needs to be alpha-numeric and camel-case formatted in "%s"!',
                $propertyName,
                $this->name
            ));
        }
    }

    /**
     * @param array $property
     *
     * @return string
     */
    private function getPropertyConstantName(array $property)
    {
        $filter = new CamelCaseToUnderscore();

        return mb_strtoupper($filter->filter($property['name']));
    }

    /**
     * @param array $property
     *
     * @return int
     */
    private function isTypedArray(array $property)
    {
        return (bool)preg_match('/array\[\]|callable\[\]|int\[\]|integer\[\]|float\[\]|string\[\]|bool\[\]|boolean\[\]|iterable\[\]|object\[\]|resource\[\]|mixed\[\]/', $property['type']);
    }

    /**
     * @param string $type
     *
     * @return bool
     */
    private function isTypeOrTypeArray($type)
    {
        return (!preg_match('/^int|^integer|^float|^string|^array|^\[\]|^bool|^boolean|^callable|^iterable|^iterator|^mixed|^resource|^object/', $type));
    }

    /**
     * @param array $property
     *
     * @return bool
     */
    private function isArray(array $property)
    {
        return ($property['type'] === 'array' || $property['type'] === '[]' || $this->isTypedArray($property));
    }

    /**
     * @param string $type
     *
     * @return bool|string
     */
    private function getSchemaType(string $type)
    {
        switch ($type) {
            case 'string':
                return 'Type::string()';
                break;
            case 'int':
            case 'integer':
                return 'Type::int()';
            case 'float':
                return 'Type::float()';
            case 'bool':
            case 'boolean':
                return 'Type::boolean()';
        }
    }

    /**
     * @param array $property
     *
     * @return array
     */
    private function buildTypePropertyDefinition(array $property)
    {
        $property['is_transfer'] = true;

        if (preg_match('/\[\]$/', $property['type'])) {
            $property['type'] = 'Type::listOf(TypeRegistry::'.str_replace('[]', '', $property['type']).'Type())';
            $property['is_collection'] = true;

            return $property;
        }

        if (strpos($property['type'], 'Type') === false) {
            $property['type'] = 'TypeRegistry::'.$property['type'].'Type()';
        } else {
            $property['type'] = 'TypeRegistry::'.$property['type'].'()';
        }

        return $property;
    }
}
