<?php

namespace Inviqa\Zed\Graphql\Business\Model\Generator\DefinitionBuilder;

interface LoaderInterface
{
    public function getDefinitions(): array;
}
