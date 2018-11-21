<?php

namespace Inviqa\Yves\Graphql\Plugin;

use Spryker\Yves\Kernel\AbstractPlugin;

abstract class AbstractGraphqlPlugin extends AbstractPlugin
{

    abstract public function getFieldName(): string;
    abstract public function getFieldType();
    abstract public function getFieldDescription(): string;
    abstract public function resolveField($args);

}
