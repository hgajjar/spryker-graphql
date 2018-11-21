<?php

namespace Inviqa\Zed\Graphql\Business\Model\Generator\DefinitionBuilder;

use Inviqa\Zed\Graphql\Business\Model\Generator\DefinitionInterface;

interface ClassDefinitionInterface extends DefinitionInterface
{

    /**
     * @return array
     */
    public function getConstructorDefinition();

    /**
     * @return array
     */
    public function getIncludeClassesDefinition();

}
