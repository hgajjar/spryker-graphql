<?php

namespace Inviqa\Zed\Graphql\Business\Model\Generator\DefinitionBuilder;

interface DefinitionNormalizerInterface
{
    public function normalizeDefinitions(array $transferDefinitions): array;
}
