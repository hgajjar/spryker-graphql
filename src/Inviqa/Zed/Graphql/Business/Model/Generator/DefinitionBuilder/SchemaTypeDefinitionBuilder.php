<?php

namespace Inviqa\Zed\Graphql\Business\Model\Generator\DefinitionBuilder;

use Inviqa\Zed\Graphql\Business\Model\Generator\DefinitionInterface;

class SchemaTypeDefinitionBuilder implements DefinitionBuilderInterface
{
    /**
     * @var LoaderInterface
     */
    private $loader;

    /**
     * @var MergerInterface
     */
    private $merger;

    /**
     * @var ClassDefinitionInterface
     */
    private $classDefinition;

    public function __construct(LoaderInterface $loader, MergerInterface $merger, ClassDefinitionInterface $classDefinition)
    {
        $this->loader = $loader;
        $this->merger = $merger;
        $this->classDefinition = $classDefinition;
    }

    /**
     * @return ClassDefinitionInterface[]|DefinitionInterface[]
     */
    public function getDefinitions(): array
    {
        $definitions = $this->loader->getDefinitions();
        $definitions = $this->merger->merge($definitions);

        return $this->buildDefinitions($definitions, $this->classDefinition);
    }

    /**
     * @param array $definitions
     * @param DefinitionInterface $definitionClass
     *
     * @return DefinitionInterface[]
     */
    protected function buildDefinitions(array $definitions, DefinitionInterface $definitionClass)
    {
        $definitionInstances = [];
        foreach ($definitions as $definition) {
            $definitionInstance = clone $definitionClass;
            $definitionInstances[] = $definitionInstance->setDefinition($definition);
        }

        return $definitionInstances;
    }
}
