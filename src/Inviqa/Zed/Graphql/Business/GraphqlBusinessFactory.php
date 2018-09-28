<?php

namespace Inviqa\Zed\Graphql\Business;

use Psr\Log\LoggerInterface;
use Inviqa\Zed\Graphql\Business\Model\Generator\DefinitionBuilder\ClassDefinition;
use Inviqa\Zed\Graphql\Business\Model\Generator\DefinitionBuilder\ClassDefinitionInterface;
use Inviqa\Zed\Graphql\Business\Model\Generator\SchemaType\ClassGenerator;
use Inviqa\Zed\Graphql\Business\Model\Generator\DefinitionBuilder\DefinitionBuilderInterface;
use Inviqa\Zed\Graphql\Business\Model\Generator\DefinitionBuilder\DefinitionNormalizer;
use Inviqa\Zed\Graphql\Business\Model\Generator\DefinitionBuilder\DefinitionNormalizerInterface;
use Inviqa\Zed\Graphql\Business\Model\Generator\DefinitionBuilder\FinderInterface;
use Inviqa\Zed\Graphql\Business\Model\Generator\GeneratorInterface;
use Inviqa\Zed\Graphql\Business\Model\Generator\DefinitionBuilder\LoaderInterface;
use Inviqa\Zed\Graphql\Business\Model\Generator\DefinitionBuilder\MergerInterface;
use Inviqa\Zed\Graphql\Business\Model\Generator\DefinitionBuilder\SchemaTypeDefinitionBuilder;
use Inviqa\Zed\Graphql\Business\Model\Generator\DefinitionBuilder\SchemaTypeDefinitionFinder;
use Inviqa\Zed\Graphql\Business\Model\Generator\DefinitionBuilder\SchemaTypeDefinitionLoader;
use Inviqa\Zed\Graphql\Business\Model\Generator\DefinitionBuilder\SchemaTypeDefinitionMerger;
use Inviqa\Zed\Graphql\Business\Model\Generator\TypeRegistry\TypeRegistryGeneratorInterface;
use Inviqa\Zed\Graphql\Business\Model\Generator\TypeRegistry\TypeRegistryGenerator;
use Inviqa\Zed\Graphql\Business\Model\SchemaGenerator;
use Inviqa\Zed\Graphql\Business\Model\SchemaGeneratorInterface;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;

/**
 * @method \Inviqa\Zed\Graphql\GraphqlConfig getConfig()
 * @method \Inviqa\Zed\Graphql\Persistence\GraphqlQueryContainer getQueryContainer()
 */
class GraphqlBusinessFactory extends AbstractBusinessFactory
{

    public function createSchemaGenerator(LoggerInterface $messenger): SchemaGeneratorInterface
    {
        return new SchemaGenerator(
            $messenger,
            $this->createClassGenerator(),
            $this->createTypeRegistryGenerator(),
            $this->createTransferDefinitionBuilder()
        );
    }

    private function createClassGenerator(): GeneratorInterface
    {
        return new ClassGenerator(
            $this->getConfig()->getClassTargetDirectory()
        );
    }

    protected function createTransferDefinitionBuilder(): DefinitionBuilderInterface
    {
        return new SchemaTypeDefinitionBuilder(
            $this->createLoader(),
            $this->createTransferDefinitionMerger(),
            $this->createClassDefinition()
        );
    }

    protected function createLoader(): LoaderInterface
    {
        return new SchemaTypeDefinitionLoader(
            $this->createFinder(),
            $this->createDefinitionNormalizer()
        );
    }

    protected function createTransferDefinitionMerger(): MergerInterface
    {
        return new SchemaTypeDefinitionMerger();
    }

    protected function createClassDefinition(): ClassDefinitionInterface
    {
        return new ClassDefinition();
    }

    protected function createFinder(): FinderInterface
    {
        return new SchemaTypeDefinitionFinder(
            $this->getConfig()->getSourceDirectories()
        );
    }

    protected function createDefinitionNormalizer(): DefinitionNormalizerInterface
    {
        return new DefinitionNormalizer();
    }

    private function createTypeRegistryGenerator(): TypeRegistryGeneratorInterface
    {
        return new TypeRegistryGenerator(
            $this->getConfig()->getClassTargetDirectory()
        );
    }

}
