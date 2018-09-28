<?php

namespace Inviqa\Zed\Graphql\Business\Model;

use Psr\Log\LoggerInterface;
use Inviqa\Zed\Graphql\Business\Model\Generator\DefinitionBuilder\DefinitionBuilderInterface;
use Inviqa\Zed\Graphql\Business\Model\Generator\GeneratorInterface;
use Inviqa\Zed\Graphql\Business\Model\Generator\TypeRegistry\TypeRegistryGeneratorInterface;

class SchemaGenerator implements SchemaGeneratorInterface
{

    /**
     * @var LoggerInterface
     */
    private $messenger;

    /**
     * @var GeneratorInterface
     */
    private $typeGenerator;

    /**
     * @var GeneratorInterface
     */
    private $typeRegistryGenerator;

    /**
     * @var DefinitionBuilderInterface
     */
    private $definitionBuilder;

    public function __construct(
        LoggerInterface $messenger,
        GeneratorInterface $typeGenerator,
        TypeRegistryGeneratorInterface $typeRegistryGenerator,
        DefinitionBuilderInterface $definitionBuilder
    )
    {
        $this->messenger = $messenger;
        $this->typeGenerator = $typeGenerator;
        $this->typeRegistryGenerator = $typeRegistryGenerator;
        $this->definitionBuilder = $definitionBuilder;
    }

    public function execute()
    {
        $definitions = $this->definitionBuilder->getDefinitions();

        $this->generateSchema($definitions);
        $this->generateTypeRegistry($definitions);
    }

    private function generateSchema(array $definitions): void
    {
        foreach ($definitions as $classDefinition) {
            $fileName = $this->typeGenerator->generate($classDefinition);
            $this->messenger->info(sprintf('<info>%s</info> was generated', $fileName));
        }
    }

    private function generateTypeRegistry(array $definitions): void
    {
        $fileName = $this->typeRegistryGenerator->generate($definitions);
        $this->messenger->info(sprintf('<info>%s</info> was generated', $fileName));
    }

}
