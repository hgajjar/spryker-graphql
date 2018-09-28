<?php

namespace Inviqa\Zed\Graphql\Business;

use Psr\Log\LoggerInterface;
use Spryker\Zed\Kernel\Business\AbstractFacade;

/**
 * @method \Inviqa\Zed\Graphql\Business\GraphqlBusinessFactory getFactory()
 */
class GraphqlFacade extends AbstractFacade implements GraphqlFacadeInterface
{

    public function generateSchemaTypes(LoggerInterface $messenger): void
    {
        $this->getFactory()->createSchemaGenerator($messenger)->execute();
    }
}
