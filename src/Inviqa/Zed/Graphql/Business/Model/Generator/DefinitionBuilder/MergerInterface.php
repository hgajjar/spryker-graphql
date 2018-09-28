<?php

namespace Inviqa\Zed\Graphql\Business\Model\Generator\DefinitionBuilder;

interface MergerInterface
{
    public function merge(array $transferDefinitions): array;
}
