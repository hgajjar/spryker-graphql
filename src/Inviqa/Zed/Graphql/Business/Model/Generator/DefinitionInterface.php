<?php

namespace Inviqa\Zed\Graphql\Business\Model\Generator;

interface DefinitionInterface
{

    public function getName(): string ;

    public function setDefinition(array $definition): DefinitionInterface;

}
