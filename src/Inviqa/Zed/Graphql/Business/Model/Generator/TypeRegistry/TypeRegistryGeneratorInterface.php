<?php

namespace Inviqa\Zed\Graphql\Business\Model\Generator\TypeRegistry;

interface TypeRegistryGeneratorInterface
{

    public function generate(array $definitions): string;

}
