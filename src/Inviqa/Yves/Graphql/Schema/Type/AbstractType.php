<?php

namespace Inviqa\Yves\Graphql\Schema\Type;

use GraphQL\Type\Definition\ObjectType;
use Spryker\Yves\Kernel\ClassResolver\Factory\FactoryResolver;

class AbstractType extends ObjectType
{

    /**
     * @var \Spryker\Yves\Kernel\AbstractFactory
     */
    private $factory;

    /**
     * @return \Spryker\Yves\Kernel\AbstractFactory
     */
    protected function getFactory()
    {
        if ($this->factory === null) {
            $this->factory = $this->resolveFactory();
        }

        return $this->factory;
    }

    /**
     * @return \Spryker\Yves\Kernel\AbstractFactory
     */
    private function resolveFactory()
    {
        return $this->getFactoryResolver()->resolve($this);
    }

    /**
     * @return \Spryker\Yves\Kernel\ClassResolver\Factory\FactoryResolver
     */
    private function getFactoryResolver()
    {
        return new FactoryResolver();
    }

}
