<?php

namespace Inviqa\Zed\Graphql\Business\Model\Generator;

interface GeneratorInterface
{

    public function generate(DefinitionInterface $definition): string;

}
